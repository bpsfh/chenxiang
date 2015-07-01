<?php
class ModelSalesmanVipCard extends Model {
	
	/**
	 * 插入业务员申请的vip卡数据
	 * @param $data
	 */
	public function addVipCard($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "vip_card SET vip_card_num = '" . $this->db->escape($data['vip_card_num'])
				 . "', salesman_id = '" . (int)$data['salesman_id'] . "', bind_status = 1" . ", date_bind_to_salesman = NOW()"
				 . ", date_created = NOW()" . ", date_modified = NOW()");
	}

}