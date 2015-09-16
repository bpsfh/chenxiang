<?php
class ModelFinanceCommissionsApply extends Model {
	
	public function getTotalSettlements($data = array()) {
		// Get the default commission percent setting value setted for the first class salesman.
		$def_site_commission_percent = 0;
		
		$sql = " SELECT ";
		$sql .= "  COUNT(*) AS total ";
		
		$sql .= " FROM (";
		
		// product order
		$sql .= " SELECT ca.salesman_id ";
		$sql .= " , NULL AS apply_id ";
		$sql .= " , DATE(DATE_SUB(o.date_added, INTERVAL DAY(o.date_added) - 1 DAY)) AS period_from ";
		$sql .= " , DATE(LAST_DAY(o.date_added)) AS period_to ";
		$sql .= " , COUNT(DISTINCT o.order_id) AS order_total ";
		$sql .= " , SUM(op.quantity * op.price) AS amount_total ";
		$sql .= " , SUM(op.quantity * comm.commission) AS commission_total ";
		$sql .= " , 0 AS status ";
		$sql .= " FROM `" . DB_PREFIX . "vip_card_assign_record` ca ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "vip_card` vc ON ca.vip_card_num = vc.vip_card_num AND ca.is_valid = 1 ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "customer` c ON vc.customer_id = c.customer_id ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "order` o ON c.customer_id = o.customer_id AND o.order_status_id = 5 ";
		$sql .= "     AND vc.date_bind_to_salesman <= o.date_added ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "order_product` op ON o.order_id = op.order_id ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "salesman` s ON vc.salesman_id = s.salesman_id ";
		
		// Get the commission setted by the parent salesman for the subordinate.
		$sql .= " INNER JOIN (";
		$sql .= " SELECT p.product_id";
		$sql .= " , CASE WHEN pc.commission IS NOT NULL THEN pc.commission ";
		$sql .= "        ELSE p.price * sps.sub_commission_def_percent / 100 ";
		$sql .= "   END AS commission ";
		$sql .= " FROM `" . DB_PREFIX . "product` p ";
		$sql .= " JOIN ( ";
		$sql .= "       SELECT ";
		$sql .= "             IFNULL(sp.salesman_id, 0) AS salesman_id ";
		$sql .= "           , CASE WHEN sp.salesman_id IS NULL THEN " . $def_site_commission_percent . " ";
		$sql .= "                  ELSE sp.sub_commission_def_percent ";
		$sql .= "             END AS sub_commission_def_percent ";
		$sql .= "       FROM `" . DB_PREFIX . "salesman` s " ;
		$sql .= "       LEFT JOIN `" . DB_PREFIX . "salesman` sp ON s.parent_id = sp.salesman_id " ;
		$sql .= "       WHERE s.salesman_id = '" . $this->db->escape($data['salesman_id']) . "') sps ";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "product_commission` pc ON p.status = 1 AND p.product_id = pc.product_id AND sps.salesman_id = pc.salesman_id AND pc.start_date <= NOW() AND pc.end_date IS NULL ";
		$sql .= " ) comm ";
		
		$sql .= "  ON op.product_id = comm.product_id ";
		
		$implode = array();
		
		if(!empty($data['salesman_id'])) {
			$implode[] .= " ca.salesman_id = '" . $this->db->escape($data['salesman_id']) . "' ";
		} else {
			$implode[] .= " 0 = 1 ";
		}
		
		if (!empty($data['filter_period_from'])) {
			$implode[] .= " DATE(o.date_added) >= '" . $this->db->escape($data['filter_period_from']) . "'";
		}
		
		if (!empty($data['filter_period_to'])) {
			$implode[] .= " DATE(o.date_added) <= '" . $this->db->escape($data['filter_period_to']) . "'";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sql .= " GROUP BY ";
		$sql .= "   ca.salesman_id ";
		$sql .= " , DATE(DATE_SUB(o.date_added, INTERVAL DAY(o.date_added) - 1 DAY)) ";
		$sql .= " , DATE(LAST_DAY(o.date_added)) ";
		
		$sql .= " ) dyna ";
		
		$sql .= " LEFT JOIN `" . DB_PREFIX . "commissions_apply` cma ";
		$sql .= " ON dyna.salesman_id = cma.salesman_id AND cma.status != 9 ";
		$sql .= " AND dyna.period_from = cma.period_from AND dyna.period_to = cma.period_to ";
		$sql .= " AND cma.salesman_id = '" . $this->db->escape($data['salesman_id']) . "'";
		
		$implode = array();
		
		// salesman_id is necessary
		if(empty($data['salesman_id'])) {
			$implode[] = " 0 = 1 ";
		}
		
		if (!empty($data['filter_period_from'])) {
			$implode[] .= " DATE(cma.period_from) >= '" . $this->db->escape($data['filter_period_from']) . "'";
		}
		
		if (!empty($data['filter_period_to'])) {
			$implode[] .= " DATE(cma.period_to) <= '" . $this->db->escape($data['filter_period_to']) . "'";
		}
		
		if (!empty($data['filter_status'])) {
			$implode[] .= " IF(cma.apply_id IS NOT NULL, cma.status, dyna.status) = '" . $data['filter_status'] . "'";
		}
		
		if (!empty($data['filter_apply_id'])) {
			$implode[] .= " cma.apply_id = '" . (int)$data['filter_apply_id'] . "'";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}

	public function getSettlementsByMonth($data = array()) {

		// Get the default commission percent setting value setted for the first class salesman. 
		$def_site_commission_percent = 0;
		$sql = " SELECT value ";
		$sql .= " FROM `" . DB_PREFIX . "setting` s ";
		$sql .= " WHERE store_id = 0 AND code = 'config' and s.key = 'config_commission_def_percent'";
  
		$query = $this->db->query($sql);

		if (!empty($query->row)) {
			$def_site_commission_percent = $query->row['value'];
  		}

		$sql = " SELECT ";
		$sql .= "    IF(cma.apply_id IS NOT NULL, cma.apply_id, dyna.apply_id) AS apply_id ";
		$sql .= "  , IF(cma.apply_id IS NOT NULL, cma.salesman_id, dyna.salesman_id) AS salesman_id ";
		$sql .= "  , IF(cma.apply_id IS NOT NULL, cma.period_from, dyna.period_from) AS period_from ";
		$sql .= "  , IF(cma.apply_id IS NOT NULL, cma.period_to, dyna.period_to) AS period_to";
		$sql .= "  , IF(cma.apply_id IS NOT NULL, cma.order_total, dyna.order_total) AS order_total ";
		$sql .= "  , IF(cma.apply_id IS NOT NULL, cma.amount_total, dyna.amount_total) AS amount_total ";
		$sql .= "  , IF(cma.apply_id IS NOT NULL, cma.commission_total, dyna.commission_total) AS commission_total ";
		$sql .= "  , IF(cma.apply_id IS NOT NULL, cma.status, dyna.status) AS status ";
		$sql .= "  , IF(cma.apply_id IS NOT NULL, cma.apply_date, NULL) AS apply_date ";
		$sql .= "  , IF(cma.apply_id IS NOT NULL, IF(cma.status = 4, 1, 0), 0) AS payment_status ";
		$sql .= "  , IF(cma.apply_id IS NOT NULL, cma.comments, NULL) AS comments ";

		$sql .= " FROM (";

		// product order
		$sql .= " SELECT ca.salesman_id ";
		$sql .= " , NULL AS apply_id ";
		$sql .= " , DATE(DATE_SUB(o.date_added, INTERVAL DAY(o.date_added) - 1 DAY)) AS period_from "; 
		$sql .= " , DATE(LAST_DAY(o.date_added)) AS period_to "; 
		$sql .= " , COUNT(DISTINCT o.order_id) AS order_total ";
		$sql .= " , SUM(op.quantity * op.price) AS amount_total ";
		$sql .= " , SUM(op.quantity * comm.commission) AS commission_total ";
		$sql .= " , 0 AS status ";
		$sql .= " FROM `" . DB_PREFIX . "vip_card_assign_record` ca ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "vip_card` vc ON ca.vip_card_num = vc.vip_card_num AND ca.is_valid = 1 ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "customer` c ON vc.customer_id = c.customer_id ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "order` o ON c.customer_id = o.customer_id AND o.order_status_id = 5 ";
		$sql .= "     AND vc.date_bind_to_salesman <= o.date_added ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "order_product` op ON o.order_id = op.order_id ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "salesman` s ON vc.salesman_id = s.salesman_id ";

		// Get the commission setted by the parent salesman for the subordinate.
		$sql .= " INNER JOIN (";
		$sql .= " SELECT p.product_id";
		$sql .= " , CASE WHEN pc.commission IS NOT NULL THEN pc.commission ";
		$sql .= "        ELSE p.price * sps.sub_commission_def_percent / 100 ";
		$sql .= "   END AS commission ";
		$sql .= " FROM `" . DB_PREFIX . "product` p ";
		$sql .= " JOIN ( "; 
		$sql .= "       SELECT "; 
		$sql .= "             IFNULL(sp.salesman_id, 0) AS salesman_id "; 
		$sql .= "           , CASE WHEN sp.salesman_id IS NULL THEN " . $def_site_commission_percent . " "; 
		$sql .= "                  ELSE sp.sub_commission_def_percent ";
		$sql .= "             END AS sub_commission_def_percent ";
		$sql .= "       FROM `" . DB_PREFIX . "salesman` s " ;
		$sql .= "       LEFT JOIN `" . DB_PREFIX . "salesman` sp ON s.parent_id = sp.salesman_id " ;
		$sql .= "       WHERE s.salesman_id = '" . $this->db->escape($data['salesman_id']) . "') sps ";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "product_commission` pc ON p.status = 1 AND p.product_id = pc.product_id ";
		$sql .= "     AND sps.salesman_id = pc.salesman_id AND pc.start_date <= NOW() AND pc.end_date IS NULL ";
		$sql .= " ) comm "; 

		$sql .= "  ON op.product_id = comm.product_id ";
		
		$implode = array();

		if(!empty($data['salesman_id'])) {
			$implode[] .= " ca.salesman_id = '" . $this->db->escape($data['salesman_id']) . "' ";
		} else {
			$implode[] .= " 0 = 1 ";
		}

		if (!empty($data['filter_period_from'])) {
			$implode[] .= " DATE(o.date_added) >= '" . $this->db->escape($data['filter_period_from']) . "'";
		}

		if (!empty($data['filter_period_to'])) {
			$implode[] .= " DATE(o.date_added) <= '" . $this->db->escape($data['filter_period_to']) . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
	
		$sql .= " GROUP BY ";
		$sql .= "   ca.salesman_id ";
		$sql .= " , DATE(DATE_SUB(o.date_added, INTERVAL DAY(o.date_added) - 1 DAY)) "; 
		$sql .= " , DATE(LAST_DAY(o.date_added)) "; 
	
		$sql .= " ) dyna "; 

		$sql .= " LEFT JOIN `" . DB_PREFIX . "commissions_apply` cma ";
		$sql .= " ON dyna.salesman_id = cma.salesman_id AND cma.status != 9 ";
		$sql .= " AND dyna.period_from = cma.period_from AND dyna.period_to = cma.period_to ";
		$sql .= " AND cma.salesman_id = '" . $this->db->escape($data['salesman_id']) . "'";
		
		$implode = array();
		
		// salesman_id is necessary
		if(empty($data['salesman_id'])) {
			$implode[] = " 0 = 1 ";
		}

		if (!empty($data['filter_period_from'])) {
			$implode[] .= " DATE(cma.period_from) >= '" . $this->db->escape($data['filter_period_from']) . "'";
		}

		if (!empty($data['filter_period_to'])) {
			$implode[] .= " DATE(cma.period_to) <= '" . $this->db->escape($data['filter_period_to']) . "'";
		}

		if (!empty($data['filter_status'])) {
			$implode[] .= " IF(cma.apply_id IS NOT NULL, cma.status, dyna.status) = '" . $data['filter_status'] . "'";
		}
		
		if (!empty($data['filter_apply_id'])) {
			$implode[] .= " cma.apply_id = '" . (int)$data['filter_apply_id'] . "'";
		}

		if ($implode) {
			$sql .= " AND" . implode(" AND ", $implode);
		}
		
		$sql .= " UNION ALL ";
		$sql .= " SELECT ";
		$sql .= "    cac.apply_id ";
		$sql .= "  , cac.salesman_id ";
		$sql .= "  , cac.period_from ";
		$sql .= "  , cac.period_to ";
		$sql .= "  , cac.order_total ";
		$sql .= "  , cac.amount_total ";
		$sql .= "  , cac.commission_total ";
		$sql .= "  , cac.status ";
		$sql .= "  , cac.apply_date ";
		$sql .= "  , IF(cac.status = 4, 1, 0) AS payment_status ";
		$sql .= "  , cac.comments ";
		$sql .= " FROM `" . DB_PREFIX . "commissions_apply` cac ";
		
		$implode = array();
		
		$implode[] = " cac.status = 9 ";
		
		// salesman_id is necessary
		if(!empty($data['salesman_id'])) {
			$implode[] = " cac.salesman_id = '" . $this->db->escape($data['salesman_id']) . "'";
		} else {
			$implode[] = " 0 = 1 ";
		}
		
		if (!empty($data['filter_period_from'])) {
			$implode[] .= " DATE(cac.period_from) >= '" . $this->db->escape($data['filter_period_from']) . "'";
		}
		
		if (!empty($data['filter_period_to'])) {
			$implode[] .= " DATE(cac.period_to) <= '" . $this->db->escape($data['filter_period_to']) . "'";
		}
		
		if (!empty($data['filter_status'])) {
			$implode[] .= " cac.status = '" . $data['filter_status'] . "'";
		}
		
		if (!empty($data['filter_apply_id'])) {
			$implode[] .= " cac.apply_id = '" . (int)$data['filter_apply_id'] . "'";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
				'apply_id',
				'period_from',
				'commission_total',
				'status',
				'apply_date',
				'payment_status'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY period_from ";
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
		
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	/**
	 * 插入佣金申请
	 */
	public function apply($data) {
		
		$sql = "INSERT INTO " . DB_PREFIX . "commissions_apply ";
		$sql .= "SET salesman_id = '" . (int)$this->salesman->getId() ."',";
		$sql .= " period_from = '" . $this->db->escape($data['period_from']) ."',";
		$sql .= " period_to = '" . $this->db->escape($data['period_to']) ."',";
		$sql .= " order_total = '" . (float)$data['order_total'] . "',";
		$sql .= " amount_total = '" . (float)$data['amount_total'] . "',";
		$sql .= " commission_total = '" . (float)$data['commission_total'] . "',";
		$sql .= " status = '1', apply_date = NOW()";
		
		$this->db->query($sql);
	}
	
}
