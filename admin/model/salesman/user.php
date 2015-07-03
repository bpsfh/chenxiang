<?php
class ModelSalesmanUser extends Model {
	
	/**
	 * 根据筛选条件查找没有审核通过的业务员
	 * @param $data 筛选条件
	 */
	public function getApplications($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "salesman ";
	
		// 查询条件作成
		$implode = array();
	
		// 业务员名称
		if (!empty($data['filter_name'])) {
			$implode[] = "fullname LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
	
		// 业务员邮箱号
		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		// 申请状态
		if (!empty($data['filter_status'])) {
			if ($data['filter_status'] == '5') {
				$implode[] = "status IN ('1', '4')";
			} else {
				$implode[] = "status = '" . (int)$data['filter_status'] . "'";;
			}
		} else {
			$implode[] = "status IN ('1', '2', '3', '4')";
		}
	
		// 首次申请时间
		if (!empty($data['filter_date_first_applied'])) {
			$implode[] = "DATE(date_first_applied) = DATE('" . $this->db->escape($data['filter_date_first_applied']) . "')";
		}
	
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
	
		$sort_data = array(
				'fullname',
				'email',
				'date_first_applied',
				'status'
		);
	
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY fullname";
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
		$sql = "SELECT COUNT(*) AS TOTAL FROM " . DB_PREFIX . "salesman ";
	
		// 查询条件作成
		$implode = array();
	
		// 业务员名称
		if (!empty($data['filter_name'])) {
			$implode[] = "fullname LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
	
		// 业务员邮箱号
		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		// 申请状态
		if (!empty($data['filter_status'])) {
			if ($data['filter_status'] == '5') {
				$implode[] = "status IN ('1', '4')";
			} else {
				$implode[] = "status = '" . (int)$data['filter_status'] . "'";;
			}
		} else {
			$implode[] = "status IN ('1', '2', '3', '4')";
		}
	
		// 首次申请时间
		if (!empty($data['filter_date_first_applied'])) {
			$implode[] = "DATE(date_first_applied) = DATE('" . $this->db->escape($data['filter_date_first_applied']) . "')";
		}
	
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
	
		$query = $this->db->query($sql);
	
		return $query->row['TOTAL'];
	}
	
	/**
	 * 取出相关用户的申请信息
	 */
	public function getApplication($salesman_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesman WHERE salesman_id = '" . (int)$salesman_id . "'");
		
		return $query->row;
	}
	
	/**
	 * 批准申请为业务员
	 */
	public function approve($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "salesman SET status = '" . (int)$data['status'] . "', date_approved = NOW() WHERE salesman_id = '" . (int)$data['salesman_id'] . "'");
	}
	
	/**
	 * 拒绝申请为业务员
	 */
	public function reject($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "salesman SET status = '" . (int)$data['status'] . "' WHERE salesman_id = '" . (int)$data['salesman_id'] . "'");
	}
}