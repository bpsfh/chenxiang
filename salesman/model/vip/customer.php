<?php
class ModelVipCustomer extends Model {
	
	public function getTotalCustomers($data = array()) {
		
                $sql = " SELECT COUNT(*) AS total ";
                $sql .= " FROM `" . DB_PREFIX . "vip_card` vc ";
                $sql .= " INNER JOIN `" . DB_PREFIX . "customer` c ON vc.customer_id = c.customer_id ";

                $implode = array();

                $implode[] = " vc.bind_status = 3 ";

                // salesman_id is necessary
                if(!empty($data['salesman_id'])) {
                        $implode[] = "vc.salesman_id = '" . $this->db->escape($data['salesman_id']) . "'";
                } else {
                        $implode[] = "0 = 1";
                }

	        if(!empty($data['filter_vip_card_id'])) {
                        $implode[] = "vc.vip_card_id = '" . $this->db->escape($data['filter_vip_card_id']) . "'";
                }

                if(!empty($data['filter_customer_id'])) {
                        $implode[] = "vc.customer_id = '" . $this->db->escape($data['filter_customer_id']) . "'";
                }

                if(!empty($data['filter_name'])) {
                        $implode[] = "c.fullname LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                }

                if(!empty($data['filter_email'])) {
                        $implode[] = "c.email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
                }

                if (!empty($data['filter_date_start'])) {
                        $implode[] = "DATE(vc.date_bind_to_salesman) >= '" . $this->db->escape($data['filter_date_start']) . "'";
                }

                if (!empty($data['filter_date_end'])) {
                        $implode[] = "DATE(vc.date_bind_to_salesman) <= '" . $this->db->escape($data['filter_date_end']) . "'";
                }

                if ($implode) {
                        $sql .= " WHERE " . implode(" AND ", $implode);
                }

                $query = $this->db->query($sql);

                return $query->row['total'];
	}

	public function getCustomers($data = array()) {
		
                $sql = " SELECT vc.vip_card_id ";
                $sql .= " , vc.customer_id ";
                $sql .= " , c.fullname";
                $sql .= " , c.email";
                $sql .= " , c.telephone";
                $sql .= " , vc.date_bind_to_customer ";
                $sql .= " , SUM(op.total) AS total ";
                $sql .= " FROM `" . DB_PREFIX . "vip_card` vc ";
                $sql .= " INNER JOIN `" . DB_PREFIX . "customer` c ON vc.customer_id = c.customer_id ";
                $sql .= " LEFT JOIN `" . DB_PREFIX . "order` o ON vc.customer_id = o.customer_id ";
                $sql .= " LEFT JOIN `" . DB_PREFIX . "order_product` op ON o.order_id = op.order_id ";

                $implode = array();

                $implode[] = " o.order_status_id = 5 ";

                $implode[] = " vc.bind_status = 3 ";

                // salesman_id is necessary
                if(!empty($data['salesman_id'])) {
                        $implode[] = "vc.salesman_id = '" . $this->db->escape($data['salesman_id']) . "'";
                } else {
                        $implode[] = "0 = 1";
                }

	        if(!empty($data['filter_vip_card_id'])) {
                        $implode[] = "vc.vip_card_id = '" . $this->db->escape($data['filter_vip_card_id']) . "'";
                }

                if(!empty($data['filter_customer_id'])) {
                        $implode[] = "vc.customer_id = '" . $this->db->escape($data['filter_customer_id']) . "'";
                }

                if(!empty($data['filter_name'])) {
                        $implode[] = "c.fullname LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                }

                if(!empty($data['filter_email'])) {
                        $implode[] = "c.email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
                }

                if(!empty($data['filter_telephone'])) {
                        $implode[] = "c.telephone LIKE '" . $this->db->escape($data['filter_telephone']) . "'";
                }

                if (!empty($data['filter_date_start'])) {
                        $implode[] = "DATE(vc.date_bind_to_salesman) >= '" . $this->db->escape($data['filter_date_start']) . "'";
                }

                if (!empty($data['filter_date_end'])) {
                        $implode[] = "DATE(vc.date_bind_to_salesman) <= '" . $this->db->escape($data['filter_date_end']) . "'";
                }

                if ($implode) {
                        $sql .= " WHERE " . implode(" AND ", $implode);
                }

                $sql .= " GROUP BY vc.vip_card_id ";
		$sql .= " , vc.customer_id ";
                $sql .= " , c.fullname ";
                $sql .= " , c.email";
                $sql .= " , c.telephone ";
                $sql .= " , vc.date_bind_to_customer ";

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
