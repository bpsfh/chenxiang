<?php
class Salesman {
	private $salesman_id;
	private $fullname;
	private $email;
	private $telephone;
	private $fax;
	private $newsletter;
	private $salesman_group_id;
	private $address_id;
	private $application_status;

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['salesman_id'])) {
			$salesman_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesman WHERE salesman_id = '" . (int)$this->session->data['salesman_id'] . "' AND status = '1'");

			if ($salesman_query->num_rows) {
				$this->salesman_id = $salesman_query->row['salesman_id'];
				$this->fullname = $salesman_query->row['fullname'];
				$this->email = $salesman_query->row['email'];
				$this->telephone = $salesman_query->row['telephone'];
				$this->fax = $salesman_query->row['fax'];
				$this->newsletter = $salesman_query->row['newsletter'];
				$this->salesman_group_id = $salesman_query->row['salesman_group_id'];
				$this->address_id = $salesman_query->row['address_id'];
				$this->application_status = $salesman_query->row['application_status'];

				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesman_ip WHERE salesman_id = '" . (int)$this->session->data['salesman_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "salesman_ip SET salesman_id = '" . (int)$this->session->data['salesman_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
				}
			} else {
				$this->logout();
			}
		}
	}

	public function login($email, $password, $override = false) {
		if ($override) {
			$salesman_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesman WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");
		} else {
			$salesman_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesman WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
		}

		if ($salesman_query->num_rows) {
			$this->session->data['salesman_id'] = $salesman_query->row['salesman_id'];

			$this->salesman_id = $salesman_query->row['salesman_id'];
			$this->fullname = $salesman_query->row['fullname'];
			$this->email = $salesman_query->row['email'];
			$this->telephone = $salesman_query->row['telephone'];
			$this->fax = $salesman_query->row['fax'];
			$this->newsletter = $salesman_query->row['newsletter'];
			$this->salesman_group_id = $salesman_query->row['salesman_group_id'];
			$this->address_id = $salesman_query->row['address_id'];

			$this->db->query("UPDATE " . DB_PREFIX . "salesman SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE salesman_id = '" . (int)$this->salesman_id . "'");

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['salesman_id']);

		$this->salesman_id = '';
		$this->fullname = '';
		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
		$this->newsletter = '';
		$this->salesman_group_id = '';
		$this->address_id = '';
	}

	public function isLogged() {
		return $this->salesman_id;
	}

	public function isAuthorized() {
		return $this->application_status == 2;
	}

	public function getApplicationStatus() {
		return $this->application_status;
	}

	public function getId() {
		return $this->salesman_id;
	}

	public function getFullName() {
		return $this->fullname;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getTelephone() {
		return $this->telephone;
	}

	public function getFax() {
		return $this->fax;
	}

	public function getNewsletter() {
		return $this->newsletter;
	}

	public function getGroupId() {
		return $this->salesman_group_id;
	}

	public function getAddressId() {
		return $this->address_id;
	}

	public function getBalance() {
	}

	public function getRewardPoints() {
	}
}
