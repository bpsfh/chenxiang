<?php
class ModelSalesmanBankAccount extends Model {

	public function addBankAccount($data) {

		$this->event->trigger('pre.salesman.add.bank_account', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "bank_account SET bank_account_num = '" . $data['bank_account_num'] . "',salesman_id = '" . (int)$this->salesman->getId() . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', bank_branch_name = '" . $this->db->escape($data['bank_branch_name']) . "', account_name = '" . $this->db->escape($data['account_name']) . "', date_added = NOW()");

		$bank_account_id = $this->db->getLastId();

		$this->event->trigger('post.salesman.add.bank_account', $bank_account_id);

		return $bank_account_id;
	}

	public function editBankAccount($bank_account_id, $data) {

		$this->event->trigger('pre.salesman.edit.bank_account', $data);

		$query = $this->db->query("UPDATE " . DB_PREFIX . "bank_account SET bank_account_num = '" . $data['bank_account_num'] . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', bank_branch_name = '" . $this->db->escape($data['bank_branch_name']) . "', account_name = '" . $this->db->escape($data['account_name']) . "' WHERE bank_account_id  = '" . (int)$bank_account_id . "' AND salesman_id = '" . (int)$this->salesman->getId() . "'");

		$this->event->trigger('post.salesman.edit.bank_account', $bank_account_id);
	}

/* 	public function deleteBankAccount($bank_account_id) {
		$this->event->trigger('pre.salesman.delete.bank_account', $bank_account_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "bank_account WHERE bank_account_id = '" . (int)$bank_account_id . "' AND salesman_id = '" . (int)$this->salesman->getId() . "'");

		$this->event->trigger('post.salesman.delete.bank_account', $bank_account_id);
	} */

	/* public function getBankAccount($bank_account_id) {
		$bank_account_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "bank_account WHERE bank_account_id = '" . (int)$bank_account_id . "' AND salesman_id = '" . (int)$this->salesman->getId() . "'");

		if ($bank_account_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$bank_account_query->row['country_id'] . "'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$bank_account_format = $country_query->row['bank_account_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$bank_account_format = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$bank_account_query->row['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}

			$bank_account_data = array(
				'bank_account_id'     => $bank_account_query->row['bank_account_id'],
				'fullname'      => $bank_account_query->row['fullname'],
				'company'        => $bank_account_query->row['company'],
				'bank_account'      => $bank_account_query->row['bank_account'],
				'postcode'       => $bank_account_query->row['postcode'],
				'shipping_telephone'       => $bank_account_query->row['shipping_telephone'],
				'city'           => $bank_account_query->row['city'],
				'zone_id'        => $bank_account_query->row['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
				'country_id'     => $bank_account_query->row['country_id'],
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'bank_account_format' => $bank_account_format,
				'custom_field'   => unserialize($bank_account_query->row['custom_field'])
			);

			return $bank_account_data;
		} else {
			return false;
		}
	} */

	public function getBankAccountes() {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bank_account WHERE salesman_id = '" . (int)$this->salesman->getId() . "'");


		return $query -> rows;
	}

/* 	public function getTotalBankAccountes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "bank_account WHERE salesman_id = '" . (int)$this->salesman->getId() . "'");

		return $query->row['total'];
	} */
}