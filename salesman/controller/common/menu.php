<?php
class ControllerCommonMenu extends Controller {
	public function index() {

		$this->load->language('common/menu');

		//-------------------------
		// translations 
		//-------------------------
		$data['text_dashboard'] = $this->language->get('text_dashboard');

		$data['text_vip_card_mgmt'] = $this->language->get('text_vip_card_mgmt');
		$data['text_vip_card_srch'] = $this->language->get('text_vip_card_srch');
		$data['text_vip_record_srch'] = $this->language->get('text_vip_record_srch');
		$data['text_vip_card_apply'] = $this->language->get('text_vip_card_apply');
		$data['text_vip_customer'] = $this->language->get('text_vip_customer');
		$data['text_vip_order'] = $this->language->get('text_vip_order');

		$data['text_finance'] = $this->language->get('text_finance');
		$data['text_unit_commission'] = $this->language->get('text_unit_commission');
		$data['text_order_commissions'] = $this->language->get('text_order_commissions');
		$data['text_commissions_apply'] = $this->language->get('text_commissions_apply');

		$data['text_account'] = $this->language->get('text_account');
		$data['text_system_notice'] = $this->language->get('text_system_notice');
		$data['text_basic_info'] = $this->language->get('text_basic_info');
		$data['text_bank_info'] = $this->language->get('text_bank_info');
		$data['text_customer_group'] = $this->language->get('text_customer_group');
		$data['text_contact_us'] = $this->language->get('text_contact_us');
		$data['text_invoice_upload'] = $this->language->get('text_invoice_upload');

		// 下级业务员管理
		$data['text_sub_salesman'] = $this->language->get('text_sub_salesman');
		$data['text_sub_salesman_user'] = $this->language->get('text_sub_salesman_user');

		$data['text_sub_salesman_contact'] = $this->language->get('text_sub_salesman_contact');

		$data['text_vip_card_application'] = $this->language->get('text_vip_card_application');
		
		$this->load->model('sub_salesman/user');
		$data['isWithGrantOpt'] = $this->model_sub_salesman_user->isWithGrantOpt($this->salesman->getId());

		// Authority
		$data['isAuthorized'] = $this->salesman->isAuthorized();
		$data['application_status'] = $this->salesman->getApplicationStatus();

		//-------------------------
		// links
		//-------------------------
		$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');

		$data['vip_card_srch'] = $this->url->link('vip/vip', 'token=' . $this->session->data['token'], 'SSL');
		$data['vip_card_apply'] = $this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'], 'SSL');
		$data['vip_order'] = $this->url->link('vip/order', 'token=' . $this->session->data['token'], 'SSL');
		$data['vip_customer'] = $this->url->link('vip/customer', 'token=' . $this->session->data['token'], 'SSL');

		$data['basic_info'] = $this->url->link('salesman/user/edit', 'token=' . $this->session->data['token'], 'SSL');
		$data['bank_info'] = $this->url->link('salesman/bank_account/edit', 'token=' . $this->session->data['token'], 'SSL');
		
		// finance
		$data['unit_commission'] = $this->url->link('finance/unit_commission', 'token=' . $this->session->data['token'], 'SSL');
		$data['order_commissions'] = $this->url->link('finance/order_commissions', 'token=' . $this->session->data['token'], 'SSL');
		$data['commissions_apply'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'], 'SSL');

		// 下级业务员管理
		$data['sub_salesman'] = $this->url->link('sub_salesman/user', 'token=' . $this->session->data['token'], 'SSL');
		$data['vip_card_application'] = $this->url->link('sub_salesman/vip_card', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['invoice_upload'] = $this->url->link('salesman/upload/index', 'token=' . $this->session->data['token'], 'SSL');
		$data['contact_us'] = $this->url->link('salesman/contact/index', 'token=' . $this->session->data['token'], 'SSL');
		$data['sub_salesman_contact'] = $this->url->link('sub_salesman/contact/index', 'token=' . $this->session->data['token'], 'SSL');
		
		return $this->load->view('common/menu.tpl', $data);
	}
}
