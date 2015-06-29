<?php
class ControllerSalesmanUser extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('salesman/user');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('salesman/user');

		$this->edit();
	}

	protected function validateForm() {
// 		if (!$this->user->hasPermission('modify', 'salesman/user')) {
// 			$this->error['warning'] = $this->language->get('error_permission');
// 		}

		if ((utf8_strlen($this->request->post['username']) < 3) || (utf8_strlen($this->request->post['username']) > 20)) {
			$this->error['username'] = $this->language->get('error_username');
		}

		$user_info = $this->model_salesman_user->getUserByUsername($this->request->post['username']);

		if (!isset($this->request->get['user_id'])) {
			if ($user_info) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		} else {
			if ($user_info && ($this->request->get['user_id'] != $user_info['user_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}

		if ((utf8_strlen(trim($this->request->post['fullname'])) < 2) || (utf8_strlen(trim($this->request->post['fullname'])) > 32)) {
			$this->error['fullname'] = $this->language->get('error_fullname');
		}

		if ($this->request->post['password'] || (!isset($this->request->get['user_id']))) {
			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$this->error['password'] = $this->language->get('error_password');
			}

			if ($this->request->post['password'] != $this->request->post['confirm']) {
				$this->error['confirm'] = $this->language->get('error_confirm');
			}
		}

		return !$this->error;
	}

	public function edit() {

		if(!$this->salesman->isLogged()) {
			return new Action('common/login');
		}

		$this->load->language('salesman/user');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('salesman/user');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_salesman_user->editUser($this->request->get['user_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('salesman/user_salesman/edit', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getSalesmanForm();
	}


	public function getSalesmanForm() {

		if(!$this->salesman->isLogged()) {
			return new Action('common/login');
		}

		$salesman_id = $this->salesman->getId();
		$this->load->model ( 'salesman/user' );
		$user_info = $this->model_salesman_user->getSalesman($salesman_id);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_username'] = $this->language->get('entry_username');
		$data['entry_user_group'] = $this->language->get('entry_user_group');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_confirm'] = $this->language->get('entry_confirm');
		$data['entry_fullname'] = $this->language->get('entry_fullname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_status'] = $this->language->get('entry_status');


		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['fullname'])) {
			$data['error_fullname'] = $this->error['fullname'];
		} else {
			$data['error_fullname'] = '';
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

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
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
				'href' => $this->url->link('salesman/user/edit', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		$data['action'] = $this->url->link('salesman/user/edit', 'token=' . $this->session->data['token'] . '&user_id=' . $salesman_id . $url, 'SSL');

		$data['cancel'] = $this->url->link('salesman/user/getSalesmanForm', 'token=' . $this->session->data['token'] . $url, 'SSL');


/* 		if (!empty($user_info)) {
			$data['salesman_group_id'] = $user_info['salesman_group_id'];
		} else {
			$data['salesman_group_id'] = '';
		}

		$this->load->model('salesman/user_group');
		$data['user_groups'] = $this->model_salesman_user_group->getUserGroups(); */

		$data['confirm'] = '';
		$data['password'] = '';

		if (!empty($user_info)) {
			$data['fullname'] = $user_info['fullname'];
		} else {
			$data['fullname'] = '';
		}

		if (!empty($user_info)) {
			$data['email'] = $user_info['email'];
		} else {
			$data['email'] = '';
		}

		if (!empty($user_info)) {
			$data['image'] = $user_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (!empty($user_info) && $user_info['image'] && is_file(DIR_IMAGE . $user_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($user_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (!empty($user_info)) {
			$data['status'] = $user_info['status'];
		} else {
			$data['status'] = 0;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('salesman/user_form.tpl', $data));

	}

}