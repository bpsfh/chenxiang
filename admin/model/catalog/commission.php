<?php
/**
 * @author HU
 */
class ModelCatalogCommission extends Model {
	
	/**
	 * 取得当前有效的产品佣金信息
	 */
	public function getVaildCommission($product_id) {

		$commission_info = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_commission WHERE product_id = '" . (int)$product_id . "' AND salesman_id = '0' AND end_date is null");

		return $commission_info->row;
	}
	
	/**
	 * 系统平台添加产品佣金
	 */
	public function addProductCommission($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_commission SET product_id = '" .  (int)$data['product_id'] . "', salesman_id = 0, commission = '" . (float)$data['product_commission'] . "', start_date = NOW()");
	}

	/**
	 * 系统平台编辑产品佣金
	 */
	public function editProductCommission($data) {
	
		$commission_info = $this->getVaildCommission($data['product_id']);
		
		// 将上次有效的产品佣金信息过期
		if (!empty($commission_info)) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_commission SET end_date = NOW() WHERE product_id = '" .  (int)$data['product_id'] . "' AND salesman_id = 0");
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_commission SET product_id = '" .  (int)$data['product_id'] . "', salesman_id = 0, commission = '" . (float)$data['product_commission'] . "', start_date = NOW()");
	}
}