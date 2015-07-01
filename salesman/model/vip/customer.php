<?php
class ModelVipCustomer extends Model {
	
	public function getAllCustomers($data = array()) {
		
		$sql = "SELECT o.* AS total FROM `" . DB_PREFIX . "order` o ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "customer` c ON o.customer_id = c.customer_id ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "vip_card` vc ON o.customer_id = vc.customer_id ";
		
		if(empty($data["filter_date_end"])) {
			$data['filter_date_end'] = date('Y-m-d', time());
		}
		
		$implode = array();

		$implode[] = "o.order_status_id = 5"; 

		if(!empty($data['salesman_id'])) {
			$implode[] = "vc.salesman_id = " . $this->db->escape($data['salesman_id']);
		}
		
		if (!empty($data['filter_date_start'])) {
			$implode[] = "DATE(date_bind_to_salesman) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$implode[] = "DATE(date_bind_to_salesman) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getTotalCustomersByDate($data = array()) {
		$customer_data = array();
		
		if(!isset($data["filter_date_end"])) {
			$data["filter_date_end"] = date('y-m-d h:i:s', time());
		}
		
		if(!isset($data["filter_date_start"])) {
			$data["filter_date_start"] = strtotime('-1 Month', strtotime($data["filter_date_start"]));
		}

		for ($i = $data["filter_date_start"]; $i < $data["filter_date_end"];
			 $i = strtotime('-1 Day', strtotime($data["filter_date_start"]))) {
			$customer_data[$i] = array(
				'day'  => $i,
				'total' => 0
			);
		}

		$implode = array();
		
		if(!empty($data['salesman_id'])) {
			$implode[] = "salesman_id = " . $this->db->escape($data['salesman_id']);
		}
		
		if (!empty($data['filter_date_end'])) {
			$implode[] = "DATE(date_bind_to_salesman) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		$query = $this->db->query("SELECT COUNT(*) AS total, date_bind_to_salesman AS day FROM `" . DB_PREFIX . "vip_card` ");

		foreach ($query->rows as $result) {
			$customer_data[$result['day']] = array(
				'day'  => $result['day'],
				'total' => $result['total']
			);
		}

		return $customer_data;
	}
	
}
