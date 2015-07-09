<?php
class ModelVipOrder extends Model {
	
	public function getTotalOrders($data = array()) {
		
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "customer` c ON o.customer_id = c.customer_id ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "vip_card` vc ON o.customer_id = vc.customer_id ";
		
		if(empty($data["filter_date_end"])) {
			$data['filter_date_end'] = date('Y-m-d', time());
		}
		
		$implode = array();

		$implode[] = "o.order_status_id = 5"; 

		// salesman_id is necessary
		if(!empty($data['salesman_id'])) {
			$implode[] = "vc.salesman_id = '" . $this->db->escape($data['salesman_id']) . "'";
		} else {
			$implode[] = "0 = 1";
		}
		
		if(!empty($data['vip_card_id'])) {
			$implode[] = "vc.vip_card_id = '" . $this->db->escape($data['vip_card_id']) . "'";
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

		return $query->row['total'];
	}
	
	public function getOrders($data = array()) {
		
		$sql = " SELECT vc.vip_card_id ";
		$sql .= " , vc.customer_id ";
		$sql .= " , op.order_id ";
		$sql .= " , o.date_added";
		$sql .= " , SUM(op.total) AS total ";
		$sql .= " , SUM(op.total) * 0.05 AS commission ";
		$sql .= " FROM `" . DB_PREFIX . "order_product` op ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "order` o ON op.order_id = o.order_id ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "customer` c ON o.customer_id = c.customer_id ";
		$sql .= " INNER JOIN `" . DB_PREFIX . "vip_card` vc ON o.customer_id = vc.customer_id ";
		
		$implode = array();

		$implode[] = "o.order_status_id = 5"; 

		// salesman_id is necessary
		if(!empty($data['salesman_id'])) {
			$implode[] = "vc.salesman_id = '" . $this->db->escape($data['salesman_id']) . "'";
		} else {
			$implode[] = "0 = 1";
		}
		
		if(!empty($data['vip_card_id'])) {
			$implode[] = "vc.vip_card_id = '" . $this->db->escape($data['vip_card_id']) . "'";
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
		
		$sql .= " group by vc.vip_card_id, vc.customer_id, o.order_id ";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getTotalSalesAmount($data = array()) {
		
		$sql = "SELECT SUM(op.total) AS total FROM `" . DB_PREFIX . "order_product` op ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "order` o ON op.order_id = o.order_id ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "customer` c ON o.customer_id = c.customer_id ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "vip_card` vc ON o.customer_id = vc.customer_id ";
		
		$implode = array();

		$implode[] = "o.order_status_id = 5"; 

		// salesman_id is necessary
		if(!empty($data['salesman_id'])) {
			$implode[] = "vc.salesman_id = " . $this->db->escape($data['salesman_id']);
		} else {
			$implode[] = "0 = 1";
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

		return $query->row['total'];
	}
	
	
	public function getTotalOrdersByDate($data = array()) {
		$customer_data = array();
		
		for ($i = strtotime($data['filter_date_start']), $j = 0; $i <= strtotime($data['filter_date_end']);
			 $i = strtotime('+1 Day', $i), $j++) {
			$customer_data[$j] = array(
				'day'  => $j,
				'total' => 0
			);
		}
		
		$sql = "SELECT COUNT(*) AS total, TIMESTAMPDIFF(DAY, '" . $this->db->escape($data['filter_date_start']) . "', o.date_added) AS day FROM `" . DB_PREFIX . "order` o ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "customer` c ON o.customer_id = c.customer_id ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "vip_card` vc ON o.customer_id = vc.customer_id ";
		
		$implode = array();
		
		if(!empty($data['salesman_id'])) {
			$implode[] = "salesman_id = " . $this->db->escape($data['salesman_id']);
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
		
		$sql .= "GROUP BY DATE(o.date_added)";
		
		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$customer_data[$result['day']] = array(
				'day'  => $result['day'],
				'total' => $result['total']
			);
		}

		return $customer_data;
	}
	
	
	public function getTotalSalesByDate($data = array()) {
		$customer_data = array();
		
		for ($i = strtotime($data['filter_date_start']), $j = 0; $i <= strtotime($data['filter_date_end']);
			 $i = strtotime('+1 Day', $i), $j++) {
			$customer_data[$j] = array(
				'day'  => $j,
				'total' => 0
			);
		}
		
		$sql = "SELECT SUM(op.total) AS total, TIMESTAMPDIFF(DAY, '" . $this->db->escape($data['filter_date_start']) . "', o.date_added) AS day FROM `" . DB_PREFIX . "order_product` op ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "order` o ON op.order_id = o.order_id ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "customer` c ON o.customer_id = c.customer_id ";
		$sql .= "INNER JOIN `" . DB_PREFIX . "vip_card` vc ON o.customer_id = vc.customer_id ";
		
		$implode = array();
		
		if(!empty($data['salesman_id'])) {
			$implode[] = "salesman_id = " . $this->db->escape($data['salesman_id']);
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
		
		$sql .= "GROUP BY DATE(o.date_added)";
		
		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$customer_data[$result['day']] = array(
				'day'  => $result['day'],
				'total' => $result['total']
			);
		}
		
		return $customer_data;
	}

}
