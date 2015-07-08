<?php
/**
 * @author HU
 */
class ControllerAccountVipRegister extends Controller {
	private $error = array();
	
	public function index() {
		
		$this->load->language('account/vip_register');
		
		$this->load->model('account/vip_card');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$data['heading_title'] = $this->language->get('text_title');
		$data['vip_heading_title'] = $this->language->get('text_vip_title');
		
		$data['entry_vip_card_num'] = $this->language->get('entry_vip_card_num');
		
		$data['button_continue'] = $this->language->get('button_continue');
		
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
				'href' => $this->url->link('account/vip_register', '', 'SSL')
		);
		
		// 上下左右的共通画面加载
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateAdd()) {
			
			if (!isset($this->error['warning']) && isset($this->request->post['vip_card_num'])) {
				$this->session->data['vip_card_num'] = $this->request->post['vip_card_num'];
				// 跳转到普通用户登录界面
				$this->response->redirect($this->url->link('account/register', '', 'SSL'));
			}			
		}
		else {
			// 如果邀请码验证不通过，返回
			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}
			
			$data['action'] = $this->url->link('account/vip_register', '', 'SSL');
			
			// 跳转到相应的view
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/vip_card.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/vip_register.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/account/vip_register.tpl', $data));
			}
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