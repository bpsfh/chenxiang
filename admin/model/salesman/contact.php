<?php
class ModelSalesmanContact extends Model {

	/**
	 * 编辑咨询信息
	 *
	 *
	 * @param
	 */
	public function editContact($contact_id, $data) {

		$this->db->query("UPDATE " . DB_PREFIX . "salesman_contact SET reply_content = '" . $this->db->escape($data['reply_content']) . "', date_replied = NOW(), reply_flg = '" . (int)1 . "'WHERE contact_id =  '". (int)$contact_id. "'");
	}

	/**
	 * 通过contact_id获取当前用户提出的咨询信息
	 *
	 *
	 * @param
	 */
	public function getContact($contact_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "salesman_contact WHERE contact_id = '".(int)$contact_id . "'";

		$query = $this->db->query($sql);

		return $query->row;
	}

	/**
	 * 通过筛选条件获取当前用户提出的咨询信息
	 *
	 *
	 * @param
	 */
	public function getContacts($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "salesman_contact WHERE contact_to = '". (int)0 .  "'";

		$implode = array();

		if (!empty($data['filter_contact_title'])) {
			$implode[] = "contact_title LIKE '%" . $this->db->escape($data['filter_contact_title']) . "%'";
		}

		if (!empty($data['filter_reply_flg'])) {
			$implode[] = "reply_flg  = '" . $this->db->escape($data['filter_reply_flg']) . "'";
		}

		if (!empty($data['filter_date_contacted_fr'])) {
			$implode[] = "DATE(date_contacted) >= DATE('" . $this->db->escape($data['filter_date_contacted_fr']) . "')";
		}

		if (!empty($data['filter_date_contacted_to'])) {
			$implode[] = "DATE(date_contacted) <= DATE('" . $this->db->escape($data['filter_date_contacted_to']) . "')";
		}

		if (!empty($data['filter_date_replied_fr'])) {
			$implode[] = "DATE(date_replied) >= DATE('" . $this->db->escape($data['filter_date_replied_fr']) . "')";
		}

		if (!empty($data['filter_date_replied_to'])) {
			$implode[] = "DATE(date_replied) <= DATE('" . $this->db->escape($data['filter_date_replied_to']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
				'contact_title',
				'reply_flg',
				'date_contacted',
				'date_replied'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY contact_title";
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

	/**
	 * 获取当前用户提出的所有咨询信息
	 *
	 * @param
	 */
	public function getTotalContacts($data){

		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salesman_contact  WHERE contact_to = '".(int)0 . "'";

		$implode = array();

		if (!empty($data['filter_contact_title'])) {
			$implode[] = "contact_title LIKE '%" . $this->db->escape($data['filter_contact_title']) . "%'";
		}

		if (!empty($data['filter_reply_flg'])) {
			$implode[] = "reply_flg  = '" . $this->db->escape($data['filter_reply_flg']) . "'";
		}

		if (!empty($data['filter_date_contacted_fr'])) {
			$implode[] = "DATE(date_contacted) >= DATE('" . $this->db->escape($data['filter_date_contacted_fr']) . "')";
		}

		if (!empty($data['filter_date_contacted_to'])) {
			$implode[] = "DATE(date_contacted) <= DATE('" . $this->db->escape($data['filter_date_contacted_to']) . "')";
		}

		if (!empty($data['filter_date_replied_fr'])) {
			$implode[] = "DATE(date_replied) >= DATE('" . $this->db->escape($data['filter_date_replied_fr']) . "')";
		}

		if (!empty($data['filter_date_replied_to'])) {
			$implode[] = "DATE(date_replied) <= DATE('" . $this->db->escape($data['filter_date_replied_to']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		$query = $this->db->query($sql);

		return $query->row['total'];
	}


}
