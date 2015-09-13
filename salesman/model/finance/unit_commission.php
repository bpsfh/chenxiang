<?php
class ModelFinanceUnitCommission extends Model {

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

	public function getProductCommission($data = array()) {

		$def_site_commission_percent = 5;

		$sql = " SELECT p.product_id";
		$sql .= " , pd.name ";
		$sql .= " , CASE WHEN pc.commission IS NOT NULL THEN pc.commission ";
		$sql .= "        ELSE p.price * IFNULL(sps.sub_commission_def_percent, 5) / 100 ";
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
		$sql .= " LEFT JOIN `" . DB_PREFIX . "product_commission` pc ON p.product_id = pc.product_id AND pc.start_date <= NOW() AND pc.end_date IS NULL ";

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
				'name',
				'commission'
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

}
