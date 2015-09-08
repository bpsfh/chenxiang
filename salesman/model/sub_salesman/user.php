<?php
/**
 * @author HU
 */
class ModelSubSalesmanUser extends Model {
	
	/**
	 * 查看是否有权限发展下级业务员
	 */
	public function isWithGrantOpt($salesman_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesman WHERE salesman_id = '" . (int)$salesman_id . "'");
		
		return $query->row['with_grant_opt'];
	}
	
	/**
	 * 根据筛选条件查找下级业务员
	 * @param $data 筛选条件
	 */
	public function getSubSalesmans($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "salesman WHERE parent_id = '" . (int)$this->salesman->getId() . "'";
		
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
		
		// 创建日期
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		// 是否有发展下级权限
		if (isset($data['filter_with_grant_opt']) && !is_null($data['filter_with_grant_opt'])) {
			$implode[] = "with_grant_opt = '" . (int)$data['filter_with_grant_opt'] . "'";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
				'salesman_id',
				'fullname',
				'email',
				'date_added',
				'with_grant_opt'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY salesman_id";
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
	 * 查找某一下级业务员相关信息
	 * @param $salesman_id 业务员id
	 */
	public function getSubSalesman($salesman_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesman WHERE salesman_id = '" . (int)$salesman_id . "'");
		
		return $query->row;
	}
	
	/**
	 * 符合条件的数量
	 * @param $data 筛选条件
	 */
	public function getTotalSubSalesmans($data = array()) {
		$sql = "SELECT COUNT(*) AS TOTAL FROM " . DB_PREFIX . "salesman WHERE parent_id = '" . (int)$this->salesman->getId() . "'";
		
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
		
		// 创建日期
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		// 是否有发展下级权限
		if (isset($data['filter_with_grant_opt']) && !is_null($data['filter_with_grant_opt'])) {
			$implode[] = "with_grant_opt = '" . (int)$data['filter_with_grant_opt'] . "'";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['TOTAL'];
	}
	
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
				$implode[] = "application_status IN ('1', '4')";
			} else {
				$implode[] = "application_status = '" . (int)$data['filter_status'] . "'";
			}
		} else {
			$implode[] = "application_status IN ('1', '2', '3', '4')";
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
				'application_status'
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
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			if ($data['filter_status'] == '5') {
				$implode[] = "application_status IN ('1', '4')";
			} else {
				$implode[] = "application_status = '" . (int)$data['filter_status'] . "'";;
			}
		} else {
			$implode[] = "application_status IN ('1', '2', '3', '4')";
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
	 * 添加下级业务员
	 * @param $data 下级业务员信息
	 */
	public function addSubSalesman($data) {
		
		// 设置下级业务员的等级
		$salesman_info = $this->getSubSalesman($this->salesman->getId());
		if (!empty($salesman_info)) {
			$level = (int)$salesman_info['level'] + 1;
		}
		else {
			$level = 1;
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "salesman SET fullname = '" . $this->db->escape($data['fullname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', image = '" . $this->db->escape($data['image']) 
				. "', newsletter = '" . (int)$data['newsletter'] . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', status = '" . (int)$data['status'] . "', approved = '" . (int)$data['approved'] . "', safe = '" . (int)$data['safe'] 
				. "', application_status = '2'" . ", date_added = NOW()" . ", date_approved = NOW()" . ", date_first_applied = NOW()" . ", parent_id = '" . (int)$this->salesman->getId() . "', level = '" . (int)$level . "', with_grant_opt = '" . (int)$data['with_grant_opt'] . "'");
	
		$salesman_id = $this->db->getLastId();
	
		if (isset($data['address'])) {
			foreach ($data['address'] as $address) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salesman_address SET salesman_id = '" . (int)$salesman_id . "', fullname = '" . $this->db->escape($address['fullname']) . "', company = '" . $this->db->escape($address['company']) . "', address = '" . $this->db->escape($address['address']) 
						. "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "'");
	
				if (isset($address['default'])) {
					$address_id = $this->db->getLastId();
	
					$this->db->query("UPDATE " . DB_PREFIX . "salesman SET address_id = '" . (int)$address_id . "' WHERE salesman_id = '" . (int)$salesman_id . "'");
				}
			}
		}
		
		// 业务员申请履历添加
		// 业务员创建履历
		$this->db->query('INSERT INTO ' . DB_PREFIX . "salesman_apply_record SET salesman_id = '" . (int)$salesman_id . "', status = '0'"
				.", date_processed = NOW()");
		// 批准业务员申请履历
		$this->db->query('INSERT INTO ' . DB_PREFIX . "salesman_apply_record SET salesman_id = '" . (int)$salesman_id . "', status = '2'"
				.", date_processed = NOW()");
	}
	
	/**
	 * 更新下级业务员信息
	 * @param $salesman_id 业务员id
	 * @param $data 业务员信息
	 */
	public function editSubSalesman($salesman_id, $data) {
	
		$this->db->query("UPDATE " . DB_PREFIX . "salesman SET fullname = '" . $this->db->escape($data['fullname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', image = '" . $this->db->escape($data['image']) 
				. "', newsletter = '" . (int)$data['newsletter'] . "', status = '" . (int)$data['status'] . "', approved = '" . (int)$data['approved'] . "', safe = '" . (int)$data['safe'] . "' with_grant_opt = '" . (int)$data['with_grant_opt'] . "' WHERE salesman_id = '" . (int)$salesman_id . "'");
	
		if ($data['password']) {
			$this->db->query("UPDATE " . DB_PREFIX . "salesman SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE salesman_id = '" . (int)$salesman_id . "'");
		}
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "salesman_address WHERE salesman_id = '" . (int)$salesman_id . "'");
	
		if (isset($data['address'])) {
			foreach ($data['address'] as $address) {
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "salesman_address SET address_id = '" . (int)$address['address_id'] . "', salesman_id = '" . (int)$salesman_id . "', fullname = '" . $this->db->escape($address['fullname']) . "', company = '" . $this->db->escape($address['company']) . "', address = '" . $this->db->escape($address['address']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "'");
	
				if (isset($address['default'])) {
					$address_id = $this->db->getLastId();
	
					$this->db->query("UPDATE " . DB_PREFIX . "salesman SET address_id = '" . (int)$address_id . "' WHERE salesman_id = '" . (int)$salesman_id . "'");
				}
			}
		}
	}

	/**
	 * 通过输入的email查找相关的业务员信息
	 * @param $email 业务员email
	 */
	public function getSalesmanByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesman WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		
		return $query->row;
	}
	
	/**
	 * 取得地址详细信息
	 * @param $address_id 
	 * @return 某条地址信息
	 */
	public function getAddress($address_id) {
		$address_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesman_address WHERE address_id = '" . (int)$address_id . "'");
	
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
	
			return array(
					'address_id'     => $address_query->row['address_id'],
					'salesman_id'    => $address_query->row['salesman_id'],
					'fullname'       => $address_query->row['fullname'],
					'company'        => $address_query->row['company'],
					'address'        => $address_query->row['address'],
					'postcode'       => $address_query->row['postcode'],
					'city'           => $address_query->row['city'],
					'zone_id'        => $address_query->row['zone_id'],
					'zone'           => $zone,
					'zone_code'      => $zone_code,
					'country_id'     => $address_query->row['country_id'],
					'country'        => $country,
					'iso_code_2'     => $iso_code_2,
					'iso_code_3'     => $iso_code_3,
					'address_format' => $address_format,
			);
		}
	}

	/**
	 * 取得某下级业务员的所有地址信息
	 * @param $salesman_id 业务员id
	 * @return 所有地址id
	 */
	public function getAddresses($salesman_id) {
		$address_data = array();
	
		$query = $this->db->query("SELECT address_id FROM " . DB_PREFIX . "salesman_address WHERE salesman_id = '" . (int)$salesman_id . "'");
	
		foreach ($query->rows as $result) {
			$address_info = $this->getAddress($result['address_id']);
	
			if ($address_info) {
				$address_data[$result['address_id']] = $address_info;
			}
		}
	
		return $address_data;
	}
}