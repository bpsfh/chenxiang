<?php
/**
 * @author HU
 */
class ModelSalesmanVipCardApplication extends Model {
	
	/**
	 * 根据筛选条件查找全部申请的数据
	 * @param $data 筛选条件
	 */
	public function getApplicationLists($data = array()) {
		$sql = "SELECT *, s.fullname FROM " . DB_PREFIX . "vip_card_application vca LEFT JOIN " . DB_PREFIX . "salesman s ON (vca.salesman_id = s.salesman_id)";
		
		// 查询条件作成
		$implode = array();
		
		// 业务员名称
		if (!empty($data['filter_fullname'])) {
			$implode[] = "s.fullname LIKE '%" . $this->db->escape($data['filter_fullname']) . "%'";
		}
		
		// 处理状态
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "vca.apply_status = '" . (int)$data['filter_status'] . "'";
		}
		
		// 申请日期
		if (!empty($data['filter_date_applied'])) {
			$implode[] = "DATE(vca.date_applied) = DATE('" . $this->db->escape($data['filter_date_applied']) . "')";
		}
		
		if ($implode) {
			$sql .= "WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
				's.fullname',
				'apply_id',
				'date_applied',
				'apply_status',
				'date_processed'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY s.fullname";
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
	 * 符合条件的数量
	 * @param $data
	 */
	public function getTotalApplications($data = array()) {
		$sql = "SELECT COUNT(*) AS TOTAL FROM " . DB_PREFIX . "vip_card_application vca LEFT JOIN " . DB_PREFIX . "salesman s ON (vca.salesman_id = s.salesman_id)";
		
		// 查询条件作成
		$implode = array();
		
		// 业务员名称
		if (!empty($data['filter_fullname'])) {
			$implode[] = "s.fullname LIKE '%" . $this->db->escape($data['filter_fullname']) . "%'";
		}
		
		// 处理状态
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "apply_status = '" . (int)$data['filter_status'] . "'";
		}
		
		// 申请日期
		if (!empty($data['filter_date_applied'])) {
			$implode[] = "DATE(date_applied) = DATE('" . $this->db->escape($data['filter_date_applied']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['TOTAL'];
	}
	
	/**
	 * 批准申请
	 * @param $apply_id 申请id
	 */
	public function approveApplication($apply_id) {
		print ($apply_id);
		$this->db->query("UPDATE " . DB_PREFIX . "vip_card_application SET apply_status = '1'" . ", date_processed = NOW()"
				 . " WHERE apply_id = '" . (int)$apply_id . "'");
	}
	
	/**
	 * 取得申请信息
	 */
	public function getApplication($apply_id) {
		$sql = "SELECT *, s.fullname FROM " . DB_PREFIX . "vip_card_application vca LEFT JOIN "
				 . DB_PREFIX . "salesman s ON (vca.salesman_id = s.salesman_id) WHERE vca.apply_id = '" . (int)$apply_id . "'";
		
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	/**
	 * 拒绝申请
	 */
	public function rejectApplication($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "vip_card_application SET apply_status = '2'" . ", date_processed = NOW()"
				. ", reject_reason = '" . $this->db->escape($data['reject_reason'])
				. "' WHERE apply_id = '" . (int)$data['apply_id'] . "'");
	}
	
	/**
	 * 查询出符合条件的数据
	 * @param $data 筛选条件
	 */
	public function getSalesmans($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "salesman WHERE fullname LIKE '%" . $this->db->escape($data['filter_fullname']) . "%'";
		
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
	
}