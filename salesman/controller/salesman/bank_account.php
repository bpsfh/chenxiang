<?php
class ControllerSalesmanBankAccount extends Controller {
	private $error = array ();
	public function index() {
		$this->load->language ( 'salesman/bank_account' );

		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );

		$this->load->model ( 'salesman/bank_account' );

		$this->edit ();
	}
	protected function validateForm() {
		if (preg_match ( '/^[0-9]{16,19}$/', $this->request->post ['bank_account_num'] ) == 0 || (utf8_strlen ( trim ( $this->request->post ['bank_account_num'] ) ) < 16) || (utf8_strlen ( trim ( $this->request->post ['bank_account_num'] ) ) > 19)) {
			$this->error ['bank_account_num'] = $this->language->get ( 'error_bank_account_num' );
		}

		if ((utf8_strlen ( trim ( $this->request->post ['bank_name'] ) ) < 3) || (utf8_strlen ( trim ( $this->request->post ['bank_name'] ) ) > 20)) {
			$this->error ['bank_name'] = $this->language->get ( 'error_bank_name' );
		}

		if ((utf8_strlen ( trim ( $this->request->post ['bank_branch_name'] ) ) < 3) || (utf8_strlen ( trim ( $this->request->post ['bank_branch_name'] ) ) > 40)) {
			$this->error ['bank_branch_name'] = $this->language->get ( 'error_bank_branch_name' );
		}

		if ((utf8_strlen ( trim ( $this->request->post ['account_name'] ) ) < 1) || (utf8_strlen ( trim ( $this->request->post ['account_name'] ) ) > 32)) {
			$this->error ['account_name'] = $this->language->get ( 'error_account_name' );
		}

		return ! $this->error;
	}
	public function edit() {
		if (! $this->salesman->isLogged ()) {
			return new Action ( 'common/login' );
		}

		$this->load->language ( 'salesman/bank_account' );

		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );

		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {

			$this->load->model ( 'salesman/bank_account' );

			$this->model_salesman_bank_account->editBankAccount ( $this->request->post ['bank_account_id'], $this->request->post );

			$this->session->data ['success'] = $this->language->get ( 'text_success' );

			$url = '';

			if (isset ( $this->request->get ['sort'] )) {
				$url .= '&sort=' . $this->request->get ['sort'];
			}

			if (isset ( $this->request->get ['order'] )) {
				$url .= '&order=' . $this->request->get ['order'];
			}

			if (isset ( $this->request->get ['page'] )) {
				$url .= '&page=' . $this->request->get ['page'];
			}

			$this->response->redirect ( $this->url->link ( 'salesman/bank_account/edit', 'token=' . $this->session->data ['token'] . $url, 'SSL' ) );
		}

		$this->getForm ();
	}
	public function getForm() {
		if (! $this->salesman->isLogged ()) {
			return new Action ( 'common/login' );
		}

		$salesman_id = $this->salesman->getId ();
		$this->load->model ( 'salesman/bank_account' );
		$bank_infos = $this->model_salesman_bank_account->getBankAccountes ( $salesman_id );
		// 为以后扩展考虑，暂时取list第一条数据
		$bank_info = $bank_infos [0];

		$data ['heading_title'] = $this->language->get ( 'heading_title' );

		$data ['text_form'] = $this->language->get ( 'text_edit' );
		$data ['text_enabled'] = $this->language->get ( 'text_enabled' );
		$data ['text_disabled'] = $this->language->get ( 'text_disabled' );

		$data ['entry_bank_name'] = $this->language->get ( 'entry_bank_name' );
		$data ['entry_bank_branch_name'] = $this->language->get ( 'entry_bank_branch_name' );
		$data ['entry_bank_account_num'] = $this->language->get ( 'entry_bank_account_num' );
		$data ['entry_account_name'] = $this->language->get ( 'entry_account_name' );

		$data ['text_yes'] = $this->language->get ( 'text_yes' );
		$data ['text_no'] = $this->language->get ( 'text_no' );
		$data ['text_select'] = $this->language->get ( 'text_select' );
		$data ['text_none'] = $this->language->get ( 'text_none' );
		$data ['text_loading'] = $this->language->get ( 'text_loading' );

		$data ['button_save'] = $this->language->get ( 'button_save' );
		$data ['button_cancel'] = $this->language->get ( 'button_cancel' );

		if (isset ( $this->error ['warning'] )) {
			$data ['error_warning'] = $this->error ['warning'];
		} else {
			$data ['error_warning'] = '';
		}

		if (isset ( $this->session->data ['success'] )) {
			$data ['success'] = $this->session->data ['success'];
			unset ( $this->session->data ['success'] );
		} else {
			$data ['success'] = '';
		}

		if (isset ( $this->error ['bank_name'] )) {
			$data ['error_bank_name'] = $this->error ['bank_name'];
		} else {
			$data ['error_bank_name'] = '';
		}

		if (isset ( $this->error ['bank_account_num'] )) {
			$data ['error_bank_account_num'] = $this->error ['bank_account_num'];
		} else {
			$data ['error_bank_account_num'] = '';
		}

		if (isset ( $this->error ['bank_branch_name'] )) {
			$data ['error_bank_branch_name'] = $this->error ['bank_branch_name'];
		} else {
			$data ['error_bank_branch_name'] = '';
		}

		if (isset ( $this->error ['account_name'] )) {
			$data ['error_account_name'] = $this->error ['account_name'];
		} else {
			$data ['error_account_name'] = '';
		}

		$url = '';

		/*
		 * if (isset($this->request->get['sort'])) {
		 * $url .= '&sort=' . $this->request->get['sort'];
		 * }
		 *
		 * if (isset($this->request->get['order'])) {
		 * $url .= '&order=' . $this->request->get['order'];
		 * }
		 *
		 * if (isset($this->request->get['page'])) {
		 * $url .= '&page=' . $this->request->get['page'];
		 * }
		 */
		$data ['breadcrumbs'] = array ();

		$data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'text_home' ),
				'href' => $this->url->link ( 'common/dashboard', 'token=' . $this->session->data ['token'], 'SSL' )
		);

		$data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'heading_title' ),
				'href' => $this->url->link ( 'salesman/bank_account/edit', 'token=' . $this->session->data ['token'] . $url, 'SSL' )
		);
		$data ['action'] = $this->url->link ( 'salesman/bank_account/edit', 'token=' . $this->session->data ['token'] . '&salesman_id=' . $salesman_id . $url, 'SSL' );

		$data ['cancel'] = $this->url->link ( 'salesman/common/dashboard', 'token=' . $this->session->data ['token'] . $url, 'SSL' );

		if (isset ( $this->request->post ['bank_name'] )) {
			$data ['bank_name'] = $this->request->post ['bank_name'];
		} elseif (! empty ( $bank_info )) {
			$data ['bank_name'] = $bank_info ['bank_name'];
		} else {
			$data ['bank_name'] = '';
		}

		if (isset ( $this->request->post ['bank_branch_name'] )) {
			$data ['bank_branch_name'] = $this->request->post ['bank_branch_name'];
		} elseif (! empty ( $bank_info )) {
			$data ['bank_branch_name'] = $bank_info ['bank_branch_name'];
		} else {
			$data ['bank_branch_name'] = '';
		}

		if (isset ( $this->request->post ['bank_account_num'] )) {
			$data ['bank_account_num'] = $this->request->post ['bank_account_num'];
		} elseif (! empty ( $bank_info )) {
			$data ['bank_account_num'] = $bank_info ['bank_account_num'];
		} else {
			$data ['bank_account_num'] = '';
		}

		if (isset ( $this->request->post ['account_name'] )) {
			$data ['account_name'] = $this->request->post ['account_name'];
		} elseif (! empty ( $bank_info )) {
			$data ['account_name'] = $bank_info ['account_name'];
		} else {
			$data ['account_name'] = 0;
		}

		if (isset ( $this->request->post ['bank_account_id'] )) {
			$data ['bank_account_id'] = $this->request->post ['bank_account_id'];
		} elseif (! empty ( $bank_info )) {
			$data ['bank_account_id'] = $bank_info ['bank_account_id'];
		} else {
			$data ['bank_account_id'] = '';
		}
		$data ['header'] = $this->load->controller ( 'common/header' );
		$data ['column_left'] = $this->load->controller ( 'common/column_left' );
		$data ['footer'] = $this->load->controller ( 'common/footer' );

		$data ['token'] = $this->session->data ['token'];

		$this->response->setOutput ( $this->load->view ( 'salesman/bank_account_form.tpl', $data ) );
	}
}