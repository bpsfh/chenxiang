<?php
class ModelSalesmanUpload extends Model {

	public function deleteUpload($upload_id) {
		$this->event->trigger('pre.salesman.upload.delete', $upload_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "file_upload WHERE upload_id = '" . (int)$upload_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "file_upload_description WHERE upload_id = '" . (int)$upload_id . "'");

		$this->event->trigger('post.salesman.upload.delete', $upload_id);
	}

	public function getUpload($upload_id) {

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "file_upload d LEFT JOIN " . DB_PREFIX . "file_upload_description dd ON (d.upload_id = dd.upload_id) WHERE d.upload_id = '" . (int)$upload_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getUploads($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "file_upload d LEFT JOIN " . DB_PREFIX . "file_upload_description dd ON (d.upload_id = dd.upload_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_salesman'])) {

			if($data['filter_salesman_son'] === '1') {
				$sql = "SELECT * FROM " . DB_PREFIX . "file_upload d LEFT JOIN " . DB_PREFIX . "file_upload_description dd ON (d.upload_id = dd.upload_id) LEFT JOIN " . DB_PREFIX . "salesman s ON (d.salesman_id = s.salesman_id) LEFT JOIN " . DB_PREFIX . "salesman s1 ON (s1.salesman_id = s.parent_id) WHERE (s.fullname LIKE '%" . $this->db->escape($data['filter_salesman']) . "%' OR s1.fullname LIKE '%" . $this->db->escape($data['filter_salesman']) . "%' ) AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			} else {
				$sql = "SELECT * FROM " . DB_PREFIX . "file_upload d LEFT JOIN " . DB_PREFIX . "file_upload_description dd ON (d.upload_id = dd.upload_id) LEFT JOIN " . DB_PREFIX . "salesman s ON (d.salesman_id = s.salesman_id) WHERE s.fullname LIKE '%" . $this->db->escape($data['filter_salesman']) . "%' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			}
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND dd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_filename'])) {
			$sql .= "AND d.filename LIKE '" . $this->db->escape($data['filter_filename']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= "AND DATE(d.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'dd.name',
			'd.filename',
			'd.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY dd.name";
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

	public function getUploadDescriptions($upload_id) {
		$file_upload_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "file_upload_description WHERE upload_id = '" . (int)$upload_id . "'");

		foreach ($query->rows as $result) {
			$file_upload_description_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $file_upload_description_data;
	}

	public function getTotalUploads($data = array()) {

		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "file_upload d LEFT JOIN " . DB_PREFIX . "file_upload_description dd ON (d.upload_id = dd.upload_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$implode = array();

		if (!empty($data['filter_salesman'])) {

			if($data['filter_salesman_son'] === '1') {
				$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "file_upload d LEFT JOIN " . DB_PREFIX . "file_upload_description dd ON (d.upload_id = dd.upload_id) LEFT JOIN " . DB_PREFIX . "salesman s ON (d.salesman_id = s.salesman_id) LEFT JOIN " . DB_PREFIX . "salesman s1 ON (s1.salesman_id = s.parent_id) WHERE (s.fullname LIKE '%" . $this->db->escape($data['filter_salesman']) . "%' OR s1.fullname LIKE '%" . $this->db->escape($data['filter_salesman']) . "%' ) AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			} else {
				$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "file_upload d LEFT JOIN " . DB_PREFIX . "file_upload_description dd ON (d.upload_id = dd.upload_id) LEFT JOIN " . DB_PREFIX . "salesman s ON (d.salesman_id = s.salesman_id) WHERE s.fullname LIKE '%" . $this->db->escape($data['filter_salesman']) . "%' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			}
		}

		if (!empty($data['filter_name'])) {
			$implode[] = "AND dd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_filename'])) {
			$implode[] = "AND d.filename LIKE '" . $this->db->escape($data['filter_filename']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "AND DATE(d.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= implode($implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getUploadByMask($mask) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "file_upload d LEFT JOIN " . DB_PREFIX . "file_upload_description dd ON (d.upload_id = dd.upload_id) WHERE d.mask = '" . $this->db->escape($mask) . "'");

		return $query->row;
	}
}