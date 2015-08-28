<?php
class ModelVipVipCardApply extends Model {

	/**
	 * 检索当前业务员申请的履历
	 *
	 * @param
	 */
	public function getApplicationLists() {
		$sql = "SELECT * FROM " . DB_PREFIX . "vip_card_application vca WHERE vca.salesman_id = '".(int)$this->salesman->getId(). "'";

		$sort_data = array(
				'vca.apply_id',
				'vca.date_applied',
				'vca.apply_qty',
				'vca.apply_status',
				'vca.apply_reason'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY vca.apply_id";
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
	 * 业务员vip邀请码新建申请
	 *
	 * @param $data
	 */
	public function addApplication($data) {

		$salesman_id = $this->salesman->getId();

		$this->db->query("INSERT INTO " . DB_PREFIX . "vip_card_application SET salesman_id = '" . (int)$salesman_id . "', apply_qty = '" . (int)$data['apply_qty'] . "', apply_reason = '" . $this->db->escape($data['apply_reason']) . "', apply_status = 0, 	date_applied = NOW()");

		$apply_id = $this->db->getLastId();

		return $apply_id;
	}

	/**
	 * 获取当前用户申请的所有VIP的数量
	 *
	 * @param
	 */
	public function getTotalVipApplications(){
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "vip_card_application vca WHERE vca.salesman_id = '".(int)$this->salesman->getId(). "'";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	/**
	 * 删除申请的VIP（还未批准）
	 *
	 * @param unknown $user_id
	 */

	public function deleteApplyID($apply_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "vip_card_application` WHERE apply_id = '" . (int)$apply_id . "'");
	}

}