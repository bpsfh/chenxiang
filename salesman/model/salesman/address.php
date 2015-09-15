<?php
class ModelSalesmanAddress extends Model {
	public function addAddress($data) {
		$this->event->trigger('pre.salesman.add.address', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "salesman_address SET salesman_id = '" . (int)$this->salesman->getId() . "', fullname = '" . $this->db->escape($data['fullname']) . "',  company = '" . $this->db->escape($data['company']). "' ,address = '" . $this->db->escape($data['address']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', city = '" . $this->db->escape($data['city']) . "', zone_id = '" . (int)$data['zone_id'] . "', country_id = '" . (int)$data['country_id'] . "', shipping_telephone = '" . $this->db->escape($data['shipping_telephone']) .  "'");

		$address_id = $this->db->getLastId();

		//edit mcc
		$total_address = $this->getTotalAddresses();

		if($total_address == 1) {

			$this->db->query("UPDATE " . DB_PREFIX . "salesman SET address_id = '" . (int)$address_id . "' WHERE salesman_id = '" . (int)$this->salesman->getId() . "'");

		}else{

			if (!empty($data['default'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "salesman SET address_id = '" . (int)$address_id . "' WHERE salesman_id = '" . (int)$this->salesman->getId() . "'");
			}

		}
		//end mcc

		$this->event->trigger('post.salesman.add.address', $address_id);

		return $address_id;
	}

	public function editAddress($address_id, $data) {
		$this->event->trigger('pre.salesman.edit.address', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "salesman_address SET fullname = '" . $this->db->escape($data['fullname']) . "',  address = '" . $this->db->escape($data['address']) . "',  company = '" . $this->db->escape($data['company']). "' , postcode = '" . $this->db->escape($data['postcode']) . "', city = '" . $this->db->escape($data['city']) . "', zone_id = '" . (int)$data['zone_id'] . "', country_id = '" . (int)$data['country_id'] . "', shipping_telephone = '" . $this->db->escape($data['shipping_telephone']) . "' WHERE address_id  = '" . (int)$address_id . "'");

		if (!empty($data['default'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "salesman SET address_id = '" . (int)$address_id . "' WHERE salesman_id = '" . (int)$this->salesman->getId() . "'");
		}

		$this->event->trigger('post.salesman.edit.address', $address_id);
	}

	public function deleteAddress($address_id) {
		$this->event->trigger('pre.salesman.delete.address', $address_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "salesman_address WHERE address_id = '" . (int)$address_id . "'");

		$this->event->trigger('post.salesman.delete.address', $address_id);
	}

	public function getAddress($address_id) {
		$address_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesman_address WHERE address_id = '" . (int)$address_id . "'");

		if ($address_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$address_query->row['country_id'] . "'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}

			$address_data = array(
				'address_id'     => $address_query->row['address_id'],
				'fullname'       => $address_query->row['fullname'],
				'company'        => $address_query->row['company'],
				'address'        => $address_query->row['address'],
				'postcode'       => $address_query->row['postcode'],
				'shipping_telephone'       => $address_query->row['shipping_telephone'],
				'city'           => $address_query->row['city'],
				'zone_id'        => $address_query->row['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
				'country_id'     => $address_query->row['country_id'],
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format
			);

			return $address_data;
		} else {
			return false;
		}
	}

	public function getAddresses() {
		$address_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesman_address WHERE salesman_id = '" . (int)$this->salesman->getId() . "'");

		foreach ($query->rows as $result) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$result['country_id'] . "'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$result['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}

			$address_data[$result['address_id']] = array(
				'address_id'     => $result['address_id'],
				'fullname'      => $result['fullname'],
				'company'        => $result['company'],
				'address'      => $result['address'],
				'postcode'       => $result['postcode'],
				'shipping_telephone'       => $result['shipping_telephone'],
				'city'           => $result['city'],
				'zone_id'        => $result['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
				'country_id'     => $result['country_id'],
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format

			);
		}

		return $address_data;
	}

	public function getTotalAddresses() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salesman_address WHERE salesman_id = '" . (int)$this->salesman->getId() . "'");

		return $query->row['total'];
	}
}