<?php
class ModelSubSalesmanUnitCommission extends Model {

	/**
	 * 取得符合条件的单位佣金数据的总数量
	 */
	public function getTotalProducts($data = array()) {

		$sql = " SELECT COUNT(*) AS total ";
		$sql .= " FROM `" . DB_PREFIX . "product` p ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id AND pd.language_id = 1 ";//AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		$implode = array();

		$implode[] = " p.status = 1 ";

		if(!empty($data['filter_name'])) {
			$implode[] = " pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	/**
	 * 取得符合条件的上级单位佣金数据
	 */
	public function getParentProdCommission($data = array()) {
		// 取得系统设置的业务员佣金默认百分比
		$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "setting s WHERE store_id = 0 AND code = 'config' and s.key = 'config_commission_def_percent'");
		
		if (!empty($query->row)) {
			$def_site_commission_percent = $query->row['value'];
		} else {
			$def_site_commission_percent = 0;
		}

		// 取得所有产品的上级佣金
		$sql = " SELECT p.product_id";
		$sql .= " , pd.name ";
		$sql .= " , CASE WHEN pc.commission IS NOT NULL THEN pc.commission ";
		$sql .= "        ELSE p.price * sps.sub_commission_def_percent / 100 ";
		$sql .= "   END AS commission ";

		$sql .= " FROM `" . DB_PREFIX . "product` p ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id AND pd.language_id = 1 ";//AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		$sql .= " JOIN ( "; 
		$sql .= "       SELECT "; 
		$sql .= "             IFNULL(sp.salesman_id, 0) AS salesman_id "; 
		$sql .= "           , CASE WHEN sp.salesman_id IS NULL THEN " . $def_site_commission_percent . " "; 
		$sql .= "                  ELSE sp.sub_commission_def_percent ";
		$sql .= "             END AS sub_commission_def_percent ";
		$sql .= "       FROM `" . DB_PREFIX . "salesman` s " ;
		$sql .= "       LEFT JOIN `" . DB_PREFIX . "salesman` sp ON s.parent_id = sp.salesman_id " ;
		$sql .= "       WHERE s.salesman_id = '" . $this->db->escape($data['salesman_id']) . "') sps ";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "product_commission` pc ON p.product_id = pc.product_id AND sps.salesman_id = pc.salesman_id AND pc.start_date <= NOW() AND pc.end_date IS NULL ";

		$implode = array();

		$implode[] = " p.status = 1 ";
		// Salesman_id is necessary.
		if(empty($data['salesman_id'])) {
			$implode[] = " 1 = 0 ";
		}

		if(!empty($data['filter_name'])) {
			$implode[] = " pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
				'product_id',
				'name'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY product_id";
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
	 * 取得符合条件的下级单位佣金数据
	 */
	public function getSubProdCommission($data = array()) {
	
		// 取得所有产品的下级佣金
		$sql = " SELECT p.product_id";
		$sql .= " , pd.name ";
		$sql .= " , CASE WHEN pc.commission IS NOT NULL THEN pc.commission ";
		$sql .= "        ELSE p.price * s.sub_commission_def_percent / 100 ";
		$sql .= "   END AS commission ";
	
		$sql .= " FROM `" . DB_PREFIX . "product` p ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id AND pd.language_id = 1 ";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "product_commission` pc ON p.product_id = pc.product_id AND pc.start_date <= NOW() AND pc.end_date IS NULL AND pc.salesman_id = '" . (int)$data['salesman_id'] . "'";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "salesman` s on s.salesman_id = '" . (int)$data['salesman_id'] . "'";
	
		$implode = array();
	
		$implode[] = " p.status = 1 ";
		// Salesman_id is necessary.
		if(empty($data['salesman_id'])) {
			$implode[] = " 1 = 0 ";
		}
	
		if(!empty($data['filter_name'])) {
			$implode[] = " pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
	
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
	
		$sort_data = array(
				'product_id',
				'name'
		);
	
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY product_id";
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
	 * 取得当前有效的产品佣金信息
	 */
	public function getVaildCommission($product_id) {
	
		$commission_info = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_commission 
				WHERE product_id = '" . (int)$product_id . "' AND salesman_id = '" . (int)$this->salesman->getId() . "' AND end_date is null");
	
		return $commission_info->row;
	}
	
	/**
	 * 编辑（插入/更新）下级佣金信息
	 */
	public function editProdCommission($data) {
	
		$commission_info = $this->getVaildCommission($data['product_id']);
	
		// 将上次有效的产品佣金信息过期
		if (!empty($commission_info)) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_commission SET end_date = NOW() WHERE product_id = '" .  (int)$data['product_id'] . "' AND salesman_id = '" . (int)$this->salesman->getId() . "'");
		}
	
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_commission SET product_id = '" .  (int)$data['product_id'] . 
				"', salesman_id = '" . (int)$this->salesman->getId() . "', commission = '" . (float)$data['commission'] . "', start_date = NOW()");
	}
}

