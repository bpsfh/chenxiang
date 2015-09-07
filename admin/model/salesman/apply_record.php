<?php
/**
 * @author HU
 */
class ModelSalesmanApplyRecord extends Model {
	
	/**
	 * 查找业务员申请履历
	 */
	public function  getRecords($salesman_id) {
		$results = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesman_apply_record WHERE salesman_id = '" . (int)$salesman_id . "' ORDER BY date_processed DESC, record_id DESC" );
		
		return $results->rows;
	}
	
	/**
	 * 插入履历
	 */
	public function insert($data) {
		$this->db->query('INSERT INTO ' . DB_PREFIX . "salesman_apply_record SET salesman_id = '" . (int)$data['salesman_id'] . "', status = '" . $data['status']
				. "', reject_reason = '" . $this->db->escape($data['reject_reason']) . "', date_processed = NOW()");
	}
	
}