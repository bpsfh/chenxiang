<?php
class ModelFinanceOrderCommissions extends Model {

	public function getTotalOrderCommissions($data = array()) {

		// Get the default commission percent setting value setted for the first class salesman.
		$def_site_commission_percent = 0;
		$sql = " SELECT value ";
		$sql .= " FROM `" . DB_PREFIX . "setting` s ";
		$sql .= " WHERE store_id = 0 AND code = 'config' and s.key = 'config_commission_def_percent'";

		$query = $this->db->query($sql);

		if (!empty($query->row)) {
			$def_site_commission_percent = $query->row['value'];
		}
		$sql = " SELECT COUNT(*) AS total FROM";
		$sql .= " (SELECT DATE(o.date_added) AS date";
		$sql .= " 	,COUNT(DISTINCT o.order_id) AS order_total";
		$sql .= " 	,SUM(p.price * op.quantity) AS amount_total";
		$sql .= " 	,SUM(pcv.commission * op.quantity) AS commissions_total";
		$sql .= " 	,ca.apply_date";
		$sql .= " FROM `" . DB_PREFIX . "vip_card_assign_record` vca";
		$sql .= " INNER JOIN `" . DB_PREFIX . "vip_card` vc ON vca.vip_card_num = vc.vip_card_num";
		$sql .= " INNER JOIN `" . DB_PREFIX . "order` o ON (vc.customer_id = o.customer_id AND o.order_status_id = 5)";
		$sql .= " INNER JOIN `" . DB_PREFIX . "order_product` op ON o.order_id = op.order_id";
		$sql .= " INNER JOIN `" . DB_PREFIX . "product` p ON op.product_id = p.product_id";

		// Get the commission setted by the parent salesman for the subordinate.
		$sql .= " INNER JOIN ";
		$sql .= " (SELECT p.product_id";
		$sql .= "	 , pd.name ";
		$sql .= "	 , CASE WHEN pc.commission IS NOT NULL THEN pc.commission ";
		$sql .= "  	      ELSE p.price * sps.sub_commission_def_percent / 100 ";
		$sql .= "  	 END AS commission ";

		$sql .= " 	FROM `" . DB_PREFIX . "product` p ";
		$sql .= " 	INNER JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id AND pd.language_id = 1 ";//AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		$sql .= " 	JOIN ( ";
		$sql .= "       	SELECT ";
		$sql .= "           	  IFNULL(sp.salesman_id, 0) AS salesman_id ";
		$sql .= "           	, CASE WHEN sp.salesman_id IS NULL THEN " . $def_site_commission_percent . " ";
		$sql .= "                  	ELSE sp.sub_commission_def_percent ";
		$sql .= "             	END AS sub_commission_def_percent ";
		$sql .= "       	FROM `" . DB_PREFIX . "salesman` s " ;
		$sql .= "       	LEFT JOIN `" . DB_PREFIX . "salesman` sp ON s.parent_id = sp.salesman_id " ;
		$sql .= "       	WHERE s.salesman_id = '" . $this->db->escape($data['salesman_id']) . "') sps ";
		$sql .= " 	LEFT JOIN `" . DB_PREFIX . "product_commission` pc ON p.product_id = pc.product_id AND sps.salesman_id = pc.salesman_id AND pc.start_date <= NOW() AND pc.end_date IS NULL ) pcv";
		$sql .= "  ON op.product_id = pcv.product_id";
		// GET commissions apply status
		$sql .= " LEFT JOIN `" . DB_PREFIX . "commissions_apply` ca ON (o.date_added >= ca.period_from AND o.date_added <= ca.period_to )";

		$sql .= "  WHERE vca.salesman_id = '" . $this->salesman->getId () ."'";

		$implode = array();

		if($data['filter_settlement_status'] == 1) {
			$implode[] = "ca.apply_date IS NOT NULL";
		}

		if (!empty($data['filter_date_start'])) {
			$implode[] = "DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$implode[] = "DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sql .= " GROUP BY DATE(o.date_added),ca.apply_date ) ot";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getOrderCommissions($data = array()) {

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
		$sql .= "    dyna.salesman_id ";
		$sql .= "  , dyna.date ";
		$sql .= "  , dyna.order_total ";
		$sql .= "  , dyna.amount_total AS amount_total ";
		$sql .= "  , dyna.commission_total AS commissions_total ";
		$sql .= "  , IF(cma.apply_id IS NOT NULL, IF(cma.status = 4, 1, 0), 0) AS settlement_status ";

		$sql .= " FROM (";

		// product order
		$sql .= " SELECT ca.salesman_id ";
		$sql .= " , DATE(o.date_added) AS date "; 
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

		if (!empty($data['filter_date_start'])) {
			$implode[] .= " DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$implode[] .= " DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
	
		$sql .= " GROUP BY ";
		$sql .= "   ca.salesman_id ";
		$sql .= " , DATE(o.date_added) "; 
	
		$sql .= " ) dyna "; 

		$sql .= " LEFT JOIN `" . DB_PREFIX . "commissions_apply` cma ";
		$sql .= " ON dyna.salesman_id = cma.salesman_id AND cma.status != 9 ";
		$sql .= " AND dyna.date >= cma.period_from AND dyna.date <= cma.period_to ";
		$sql .= " AND cma.salesman_id = '" . $this->db->escape($data['salesman_id']) . "'";
		
		$implode = array();
		
		// salesman_id is necessary
		if(empty($data['salesman_id'])) {
			$implode[] = " 0 = 1 ";
		}

		if (!empty($data['filter_date_start'])) {
			$implode[] .= " DATE(cma.period_from) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$implode[] .= " DATE(cma.period_to) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if ($implode) {
			$sql .= " AND" . implode(" AND ", $implode);
		}

		$implode = array();

		if (!empty($data['filter_settlement_status'])) {
			$implode[] .= " IF(cma.apply_id IS NOT NULL, IF(cma.status = 4, 1, 0), 0) = " . $data['filter_settlement_status'];
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
				'date',
				'order_total',
				'amount_total',
				'commissions_total',
				'settlement_status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date ";
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

}
