<?php
class ControllerVipVipCardApply extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('vip/vip_card_apply');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('vip/vip_card_apply');

		$this->getList();
	}


	public function getList() {
		if (! $this->salesman->isLogged ()) {
			return new Action ( 'common/login' );
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'apply_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		$data['add'] = $this->url->link('vip/vip_card_apply/addVipApply', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('vip/vip_card_apply/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$vip_card_apply_total = $this->model_vip_vip_card_apply->getTotalVipApplications();

		$results = $this->model_vip_vip_card_apply->getApplicationLists();

		foreach ($results as $key=>$result) {

			$data['vip_card_applys'][] = array(
				'apply_id'                => $result['apply_id'],
				'num'                     => $key+1,
				'date_applied'              => $result['date_applied'],
				'apply_qty'               => $result['apply_qty'],
				'apply_status'            => $result['apply_status'],
				'apply_reason'            => $result['apply_reason'],
				'reject_reason'           => $result['reject_reason'],
				'if_applied'         => ((!is_null($result['apply_status'])) && (int)$result['apply_status'] === 0 ? true : false)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['text_apply_status_0'] = $this->language->get('text_apply_status_0');
		$data['text_apply_status_1'] = $this->language->get('text_apply_status_1');
		$data['text_apply_status_2'] = $this->language->get('text_apply_status_2');

		$data['column_num'] = $this->language->get('column_num');
		$data['column_apply_qty'] = $this->language->get('column_apply_qty');
		$data['column_apply_id'] = $this->language->get('column_apply_id');
		$data['column_date_applied'] = $this->language->get('column_date_applied');
		$data['column_examine_approve_status'] = $this->language->get('column_examine_approve_status');
		$data['column_examine_approve_reason'] = $this->language->get('column_examine_approve_reason');
		$data['column_reject_reason'] = $this->language->get('column_reject_reason');


		$data['button_submit'] = $this->language->get('button_submit');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		$data['text_form'] = !isset($this->request->get['apply_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_apply_qty'] = $this->language->get('entry_apply_qty');
		$data['entry_apply_reason'] = $this->language->get('entry_apply_reason');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		$data['token'] = $this->session->data['token'];

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
		
		if (isset($this->error['apply_qty'])) {
			$data['error_apply_qty'] = $this->language->get('error_apply_qty');
		} else {
			$data['error_apply_qty'] = '';
		}

		if (isset($this->error['apply_reason'])) {
			$data['error_apply_reason'] = $this->language->get('error_apply_reason'); 
		} else {
			$data['error_apply_reason'] = '';
			
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_apply_id'] = $this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . '&sort=vca.apply_id' . $url, 'SSL');
		$data['sort_date_applied'] = $this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . '&sort=vca.date_applied' . $url, 'SSL');
		$data['sort_apply_qty'] = $this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . '&sort=vca.apply_qty' . $url, 'SSL');
		$data['sort_apply_status'] = $this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . '&sort=vca.apply_status' . $url, 'SSL');
		$data['sort_apply_reason'] = $this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . '&sort=vca.apply_reason' . $url, 'SSL');

		if (!isset($this->request->get['apply_id'])) {
			$data['action'] = $this->url->link('vip/vip_card_apply/addVipApply', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('vip/vip_card_apply/delete', 'token=' . $this->session->data['token'] . '&user_id=' . $this->request->get['user_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		if (isset($this->request->post['apply_qty'])) {
			$data['apply_qty'] = $this->request->post['apply_qty'];
		} else {
			$data['apply_qty'] = '';
		}

		if (isset($this->request->post['apply_reason'])) {
			$data['apply_reason'] = $this->request->post['apply_reason'];
		} else {
			$data['apply_reason'] = '';
		}


		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		$pagination = new Pagination();
		$pagination->total = $vip_card_apply_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($vip_card_apply_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($vip_card_apply_total - $this->config->get('config_limit_admin'))) ? $vip_card_apply_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $vip_card_apply_total, ceil($vip_card_apply_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('vip/vip_card_apply_list.tpl', $data));
	}

	protected function validateForm() {

		if (preg_match ( '/^[1-9]\d*$/', $this->request->post ['apply_qty'] ) == 0) {
			$this->error['apply_qty'] = $this->language->get('error_apply_qty');
		}

		if (utf8_strlen(trim($this->request->post['apply_reason'])) > 200) {
			$this->error['apply_reason'] = $this->language->get('error_apply_reason');
		}
		return !$this->error;
	}

	public function addVipApply() {

		if (! $this->salesman->isLogged ()) {
			return new Action ( 'common/login' );
		}

		$this->load->language('vip/vip_card_apply');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('vip/vip_card_apply');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_vip_vip_card_apply->addApplication($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}


/*	protected function getForm() {

		if (! $this->salesman->isLogged ()) {
			return new Action ( 'common/login' );
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['apply_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_apply_qty'] = $this->language->get('entry_apply_qty');
		$data['entry_apply_reason'] = $this->language->get('entry_apply_reason');

		$data['error_apply_qty'] = $this->language->get('error_apply_qty');
		$data['error_apply_reason'] = $this->language->get('error_apply_reason');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['apply_qty'])) {
			$data['error_apply_qty'] = $this->error['error_apply_qty'];
		} else {
			$data['error_apply_qty'] = '';
		}

		if (isset($this->error['apply_reason'])) {
			$data['error_apply_reason'] = $this->error['error_apply_reason'];
		} else {
			$data['error_apply_reason'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['action'] = $this->url->link('vip/vip_card_apply/addVipApply', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['cancel'] = $this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->post['apply_qty'])) {
			$data['apply_qty'] = $this->request->post['apply_qty'];
		} else {
			$data['apply_qty'] = '';
		}

		if (isset($this->request->post['apply_reason'])) {
			$data['apply_reason'] = $this->request->post['apply_reason'];
		} else {
			$data['apply_reason'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('vip/vip_card_apply_form.tpl', $data));
	}
	
 	public function delete() {

		if (! $this->salesman->isLogged ()) {
			return new Action ( 'common/login' );
		}

		$this->load->language('vip/vip_card_apply');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('vip/vip_card_apply');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $user_id) {
				$this->model_user_user->deleteUser($user_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('vip/vip_card_apply', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'user/user')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['selected'] as $user_id) {
			if ($this->user->getId() == $user_id) {
				$this->error['warning'] = $this->language->get('error_account');
			}
		}

		return !$this->error;
	} */
}