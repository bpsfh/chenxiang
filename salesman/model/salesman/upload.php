<?php
class ModelSalesmanUpload extends Model {
	public function addUpload($salesman_id, $data) {
		$this->event->trigger('pre.salesman.upload.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "salesman_upload SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', date_added = NOW() ,salesman_id = '" . (int)$salesman_id . "' ,category = '" . (int)$this->db->escape($data['category']) . "'");

		$upload_id = $this->db->getLastId();

		foreach ($data['salesman_upload_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "salesman_upload_description SET upload_id = '" . (int)$upload_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->event->trigger('post.salesman.upload.add', $upload_id);

		return $upload_id;
	}

	public function editUpload($upload_id, $data) {
		$this->event->trigger('pre.salesman.upload.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "salesman_upload SET filename = '" . $this->db->escape($data['filename']) . "',category = '" . (int)$this->db->escape($data['category']) . "', mask = '" . $this->db->escape($data['mask']) . "' WHERE upload_id = '" . (int)$upload_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "salesman_upload_description WHERE upload_id = '" . (int)$upload_id . "'");

		foreach ($data['salesman_upload_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "salesman_upload_description SET upload_id = '" . (int)$upload_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->event->trigger('post.salesman.upload.edit', $upload_id);
	}

	public function deleteUpload($upload_id) {
		$this->event->trigger('pre.salesman.upload.delete', $upload_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "salesman_upload WHERE upload_id = '" . (int)$upload_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "salesman_upload_description WHERE upload_id = '" . (int)$upload_id . "'");

		$this->event->trigger('post.salesman.upload.delete', $upload_id);
	}

	public function getUpload($upload_id) {
		$salesman_id = $this->salesman->getId ();

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesman_upload d LEFT JOIN " . DB_PREFIX . "salesman_upload_description dd ON (d.upload_id = dd.upload_id) WHERE d.upload_id = '" . (int)$upload_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'AND d.salesman_id = '" . (int)$salesman_id . "'");

		return $query->row;
	}

	public function getSalesmanImgUpload($salesman_id, $category) {

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesman_upload d LEFT JOIN " . DB_PREFIX . "salesman_upload_description dd ON (d.upload_id = dd.upload_id) WHERE  dd.language_id = '" . (int)$this->config->get('config_language_id') . "'AND d.category = '" . (int)$category . "' AND d.salesman_id = '" . (int)$salesman_id . "'limit 1");

		return $query->row;
	}

	public function getUploads($data = array()) {

		$salesman_id = $this->salesman->getId ();

		$sql = "SELECT * FROM " . DB_PREFIX . "salesman_upload d LEFT JOIN " . DB_PREFIX . "salesman_upload_description dd ON (d.upload_id = dd.upload_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'AND d.salesman_id = '" . (int)$salesman_id . "'";

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
		$salesman_upload_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesman_upload_description WHERE upload_id = '" . (int)$upload_id . "'");

		foreach ($query->rows as $result) {
			$salesman_upload_description_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $salesman_upload_description_data;
	}

	public function getTotalUploads($data = array()) {
		$salesman_id = $this->salesman->getId ();

		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salesman_upload d LEFT JOIN " . DB_PREFIX . "salesman_upload_description dd ON (d.upload_id = dd.upload_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'AND d.salesman_id = '" . (int)$salesman_id . "'";

		$implode = array();

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
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesman_upload d LEFT JOIN " . DB_PREFIX . "salesman_upload_description dd ON (d.upload_id = dd.upload_id) WHERE d.mask = '" . $this->db->escape($mask) . "'");

		return $query->row;
	}
}