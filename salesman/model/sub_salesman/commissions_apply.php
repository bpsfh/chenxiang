<?php
/**
 * @author HU
 */
class ModelSubSalesmanCommissionsApply extends Model {
	
	public function getTotalApplys($data = array()) {
		
		$sql = " SELECT COUNT(*) AS total ";
		$sql .= " FROM " . DB_PREFIX . "commissions_apply ca";
		$sql .= " LEFT JOIN " . DB_PREFIX . "salesman s ON s.salesman_id = ca.salesman_id ";
		$sql .= " WHERE s.parent_id = '" . $this->salesman->getId() . "' ";
		
		$implode = array();
		
		if (!empty($data['filter_apply_id'])) {
			$implode[] .= " ca.apply_id = '" . (int)$data['filter_apply_id'] . "'";
		}
		
		if (!empty($data['filter_fullname'])) {
			$implode[] = " s.fullname LIKE '%" . $this->db->escape($data['filter_fullname']) . "%'";
		}
		
		if (!empty($data['filter_status'])) {
			$implode[] .= " ca.status = '" . $data['filter_status'] . "'";
		}
		
		if (!empty($data['filter_period_from'])) {
			$implode[] .= " DATE(ca.period_from) >= DATE('" . $this->db->escape($data['filter_period_from']) . "')";
		}
		
		if (!empty($data['filter_period_to'])) {
			$implode[] .= " DATE(ca.period_to) <= DATE('" . $this->db->escape($data['filter_period_to']) . "')";
		}
		
		if (!empty($data['filter_apply_date'])) {
			$implode[] .= " DATE(ca.apply_date) = DATE('" . $this->db->escape($data['filter_apply_date']) . "')";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}

	/**
	 * 根据条件查找业务员佣金申请信息
	 */
	public function getCommissionApplys($data = array()) {

		$sql = " SELECT ca.*, s.fullname ";
		$sql .= " FROM " . DB_PREFIX . "commissions_apply ca";
		$sql .= " LEFT JOIN " . DB_PREFIX . "salesman s ON s.salesman_id = ca.salesman_id ";
		$sql .= " WHERE s.parent_id = '" . $this->salesman->getId() . "' ";
		
		$implode = array();
		
		if (!empty($data['filter_apply_id'])) {
			$implode[] .= " ca.apply_id = '" . (int)$data['filter_apply_id'] . "'";
		}
		
		if (!empty($data['filter_fullname'])) {
			$implode[] = " s.fullname LIKE '%" . $this->db->escape($data['filter_fullname']) . "%'";
		}
		
		if (!empty($data['filter_status'])) {
			$implode[] .= " ca.status = '" . $data['filter_status'] . "'";
		}
		
		if (!empty($data['filter_period_from'])) {
			$implode[] .= " DATE(ca.period_from) >= DATE('" . $this->db->escape($data['filter_period_from']) . "')";
		}
		
		if (!empty($data['filter_period_to'])) {
			$implode[] .= " DATE(ca.period_to) <= DATE('" . $this->db->escape($data['filter_period_to']) . "')";
		}
		
		if (!empty($data['filter_apply_date'])) {
			$implode[] .= " DATE(ca.apply_date) = DATE('" . $this->db->escape($data['filter_apply_date']) . "')";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
				'apply_id',
				'apply_date',
				'salesman_id',
				'period_from',
				'commission_total',
				'status',
				'apply_date'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY apply_id ";
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
	 * 根据申请id查找佣金申请信息
	 */
	public function getCommissionApply($apply_id) {
		
		$sql = " SELECT ca.*, s.fullname ";
		$sql .= " FROM " . DB_PREFIX . "commissions_apply ca";
		$sql .= " LEFT JOIN " . DB_PREFIX . "salesman s ON s.salesman_id = ca.salesman_id ";
		$sql .= " WHERE s.parent_id = '" . $this->salesman->getId() . "' ";
		$sql .= " AND ca.apply_id = '" . (int)$apply_id . "'";
		
		$query = $this->db->query($sql);
		
		return $query->row;
	}
	
	/**
	 * 编辑申请(取消结算、批准，结算完成，拒绝)
	 */
	public function edit($data = array()) {
	
		$sql = " UPDATE " . DB_PREFIX . "commissions_apply";
		$sql .= " SET status = '" . $data['status'] . "', ";
		$sql .= " comments = '" . $data['comments'] . "', ";
		
		if ($data['status'] == 2) {
			$sql .= " cancel_date = NOW() ";
		} elseif ($data['status'] == 3) {
			$sql .= " approve_date = NOW() ";
		} elseif ($data['status'] == 4) {
			$sql .= " pay_date = NOW() ";
		} elseif ($data['status'] == 9) {
			$sql .= " reject_date = NOW() ";
		}
		
		$sql .= " WHERE apply_id = '" . (int)$data['apply_id'] . "'";
	
		$this->db->query($sql);
	}
	
}
