<?php
class ModelAccountVipCard extends Model {
	
	private $NOT_EXIST = 1;
	private $USED = 2;
	private $VALID = 0;
	
	/**
	 * 将输入的邀请码和目前会员绑定
	 * @param $vip_card_num
	 * @return unknown
	 */
	public function editVipCard($vip_card_num) {

		$this->db->query("UPDATE " . DB_PREFIX . "vip_card SET customer_id = '" . (int)$this->customer->getId() . "', bind_status = 3" . ", date_bind_to_customer = NOW()" . ", date_modified = NOW()" . " WHERE vip_card_num = '" . $this->db->escape($vip_card_num) . "'");

		return $vip_card_num;
	}

	/**
	 * 根据会员id获取已绑定的邀请码
	 */
	public function getVipCardNum() {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "vip_card WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		return $query->row;
	}

	/**
	 * 查看邀请码是否存在,如果不存在返回1
	 * 如果已被其他客户使用，返回2，否则返回0
	 * @param $vip_card_num
	 * @return boolean
	 */
	public function checkValid($vip_card_num) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vip_card WHERE vip_card_num = '" . $this->db->escape($vip_card_num) . "'" );

		if ($query->num_rows) {
			if (empty($query->row['customer_id'])) {
				return $this->VALID;
			}
			else {
				return $this->USED;
			}
		}
		else {
			return $this->NOT_EXIST;
		}
		
	}
	
}