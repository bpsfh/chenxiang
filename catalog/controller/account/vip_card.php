<?php
/**
 * @author HU
 */
class ControllerAccountVipCard extends Controller {
	private $error = array();
	
	public function index() {
		
		// 判断客户是否已登录，如果没登陆跳转到登陆画面，登录完成后再跳转到缓存中相应的画面
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/vip_card', '', 'SSL');
		
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		$this->load->language('account/vip_card');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		// 如果升级vip的情况
		$this->load->model('account/vip_card');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateAdd()) {
			$this->model_account_vip_card->editVipCard($this->request->post['vip_card_num']);
			
			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		// 为画面参数等做准备
		$data['heading_title'] = $this->language->get('text_title');
		$data['vip_heading_title'] = $this->language->get('text_vip_title');
		
		$data['entry_vip_card_id'] = $this->language->get('entry_vip_card_id');
		$data['entry_vip_card_num'] = $this->language->get('entry_vip_card_num');
		$data['entry_date_bind_to_customer'] = $this->language->get('entry_date_bind_to_customer');
		
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');
		
		$data['action'] = $this->url->link('account/vip_card', '', 'SSL');
		
		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$vip_card_info = $this->model_account_vip_card->getVipCardNum();
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		if (isset($this->error['error_vip_card_num'])) {
			$data['error_vip_card_num'] = $this->error['error_vip_card_num'];
		} else {
			$data['error_vip_card_num'] = '';
		}
		
		if (!empty($vip_card_info)) {
			$data['vip_card_id'] = $vip_card_info['vip_card_id'];
		} else {
			$data['vip_card_id'] = '';
		}
		
		if (isset($this->request->post['vip_card_num'])) {
			$data['vip_card_num'] = $this->request->post['vip_card_num'];
		} elseif (!empty($vip_card_info)) {
			$data['vip_card_num'] = $vip_card_info['vip_card_num'];
		} else {
			$data['vip_card_num'] = '';
		}
		
		if (!empty($vip_card_info)) {
			$data['date_bind_to_customer'] = $vip_card_info['date_bind_to_customer'];
		} else {
			$data['date_bind_to_customer'] = '';
		}
		
		// 导航栏
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
		);
		
		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_account'),
				'href' => $this->url->link('account/account', '', 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('account/vip_card', '', 'SSL')
		);
		
		
		$data['back'] = $this->url->link('account/account', '', 'SSL');
		
		// 上下左右的共通画面加载
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		// 跳转到相应的view
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/vip_card.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/vip_card.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/vip_card.tpl', $data));
		}
	}
	
	protected function validateAdd() {
		$status = $this->model_account_vip_card->checkValid($this->request->post['vip_card_num']);
		
		if ($status == 1) {
			$this->error['warning'] = $this->language->get('error_no_exist');
		}
		else if ($status == 2) {
			$this->error['warning'] = $this->language->get('error_used');
		}
	
		return !$this->error;
	}
	
}