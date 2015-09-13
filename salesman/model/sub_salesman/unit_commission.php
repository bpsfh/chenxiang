<?php
class ModelSubSalesmanUnitCommission extends Model {

	/**
	 * 取得符合条件的单位佣金数据的总数量
	 */
	public function getTotalProducts($data = array()) {

		$sql = " SELECT COUNT(*) AS total ";
		$sql .= " FROM `" . DB_PREFIX . "product` p ";

		$implode = array();

		$implode[] = " p.status = 1 ";

		if(!empty($data['name'])) {
			$implode[] = " pd.name LIKE '%" . $this->db->escape($data['name']) . "%'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	/**
	 * 取得符合条件的单位佣金数据
	 */
	public function getProductCommission($data = array()) {
		// 取得系统设置的业务员佣金默认百分比
		$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "setting s WHERE store_id = 0 AND code = 'config' and s.key = 'config_commission_def_percent'");
		
		if (!empty($query->row)) {
			$def_site_commission_percent = $query->row['config_commission_def_percent'];
		} else {
			$def_site_commission_percent = 5;
		}

		// 取得所有产品的上级佣金
		$sql = " SELECT p.product_id";
		$sql .= " , pd.name ";
		$sql .= " , CASE WHEN pc.commission IS NULL THEN p.price * IFNULL(sp.sub_commission_def_percent, " . $def_site_commission_percent. ") / 100 ";
		$sql .= "        ELSE pc.commission ";
		$sql .= "   END AS commission ";
		$sql .= " FROM `" . DB_PREFIX . "product` p ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "product_description` pd ON p.product_id = pd.product_id ";//AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		$clause_salesman_id = "";
		if(!empty($data['salesman_id'])) {
			$clause_salesman_id = "salesman_id = '" . $this->db->escape($data['salesman_id']) . "' ";
		}
		
		$sql .= " LEFT JOIN `" . DB_PREFIX . "product_commission` pc ON p.product_id = pc.product_id AND pc.start_date <= NOW() AND pc.end_date IS NULL ";

		if(!empty($clause_salesman_id)) {
			$sql .= " AND pc." . $clause_salesman_id;
		}
		
		$sql .= " LEFT JOIN `" . DB_PREFIX . "salesman` sp ON pc.salesman_id = sp.salesman_id ";
		$sql .= " LEFT JOIN `" . DB_PREFIX . "salesman` s ON s.parent_id = sp.salesman_id ";

		if(!empty($clause_salesman_id)) {
			$sql .= " AND s." . $clause_salesman_id;
		}
		
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
		
		$sql .= " ORDER BY p.product_id "; 
		
		echo $sql;

		$query = $this->db->query($sql);

		return $query->rows;
	}

}
