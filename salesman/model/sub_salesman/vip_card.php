<?php
/**
 * @author HU
 */
class ModelSubSalesmanVipCard extends Model {
	
	/**
	 * 插入业务员申请的vip卡数据
	 * @param $data
	 */
	public function addVipCard($data) {
		
		foreach ($this->getEnabledVipCards($data['apply_qty']) as $vipCardInfo) {
			$this->db->query("UPDATE " . DB_PREFIX . "vip_card SET salesman_id = '" . (int)$data['salesman_id'] . "', date_bind_to_salesman = NOW()"
					. ", date_modified = NOW() WHERE vip_card_id = '" . $vipCardInfo['vip_card_id'] . "'");
			
			// VIP卡分配记录表数据整理
			$assignRecord['vip_card_num'] = $vipCardInfo['vip_card_num'];
			$assignRecord['salesman_id'] = $data['salesman_id'];
			
			$this->addVipCardAssignRecord($assignRecord);
		}
	}
	
	
	/**
	 * 插入VIP卡分配记录表
	 */
	public function addVipCardAssignRecord($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "vip_card_assign_record SET vip_card_num = '" . $this->db->escape($data['vip_card_num'])
				. "', salesman_id = '" . (int)$data['salesman_id'] . "', date_created = NOW()" . ", date_modified = NOW(), is_valid = true");
	}
	
	
	/**
	 * 查询当前业务员所拥有的可用VIP卡的数量
	 */
	public function getTotalEnabledVipCard() {
		$sql = "SELECT COUNT(*) AS TOTAL FROM " . DB_PREFIX . "vip_card WHERE salesman_id = '" . (int)$this->salesman->getId()
		. "' AND customer_id is null AND bind_status != '2'";
	
		$query = $this->db->query($sql);
		return $query->row['TOTAL'];
	}
	
	
	/**
	 * 查询当前业务员所拥有的可用VIP卡的数量
	 */
	public function getEnabledVipCards($apply_qty) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vip_card WHERE salesman_id = '" . (int)$this->salesman->getId()
		. "' AND customer_id is null AND bind_status != '2' ORDER BY vip_card_id LIMIT " . (int)$apply_qty;
	
		$query = $this->db->query($sql);
		return $query->rows;
	}
}