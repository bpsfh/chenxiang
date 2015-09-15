<?php
/**
 * @author HU 
 */
class ControllerSalesmanCommissionsApply extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('salesman/commissions_apply');
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('salesman/commissions_apply');

		$this->getList();
	}
	
	/**
	 * 编辑申请(取消结算、批准，结算完成，拒绝)
	 */
	public function edit() {
		$this->load->language('salesman/commissions_apply');
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('salesman/commissions_apply');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_salesman_commissions_apply->edit($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_fullname'])) {
				$url .= '&filter_fullname=' . $this->request->get['filter_fullname'];
			}
			
			if (isset($this->request->get['filter_settle_status'])) {
				$url .= '&filter_settle_status=' . $this->request->get['filter_settle_status'];
			}
			
			if (isset($this->request->get['filter_apply_id'])) {
				$url .= '&filter_apply_id=' . $this->request->get['filter_apply_id'];
			}
			
			if (isset($this->request->get['filter_period_from'])) {
				$url .= '&filter_period_from=' . $this->request->get['filter_period_from'];
			}
			
			if (isset($this->request->get['filter_period_to'])) {
				$url .= '&filter_period_to=' . $this->request->get['filter_period_to'];
			}
			
			if (isset($this->request->get['filter_apply_date'])) {
				$url .= '&filter_apply_date=' . $this->request->get['filter_apply_date'];
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('salesman/commissions_apply', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
			
		$this->getFrom();
	}

	/**
	 * 业务员佣金结算申请一览
	 */
	protected function getList() {

		if (isset($this->request->get['filter_fullname'])) {
			$filter_fullname = $this->request->get['filter_fullname'];
		} else {
			$filter_fullname = null;
		}
		
		if (isset($this->request->get['filter_settle_status'])) {
			$filter_settle_status = $this->request->get['filter_settle_status'];
		} else {
			$filter_settle_status = null;
		}
		
		if (isset($this->request->get['filter_apply_id'])) {
			$filter_apply_id = $this->request->get['filter_apply_id'];
		} else {
			$filter_apply_id = null;
		}
		
		if (isset($this->request->get['filter_period_from'])) {
			$filter_period_from = $this->request->get['filter_period_from'];
		} else {
			$filter_period_from= null;
		}
		
		if (isset($this->request->get['filter_period_to'])) {
			$filter_period_to = $this->request->get['filter_period_to'];
		} else {
			$filter_period_to = null;
		}
		
		if (isset($this->request->get['filter_apply_date'])) {
			$filter_apply_date = $this->request->get['filter_apply_date'];
		} else {
			$filter_apply_date = null;
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

		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . $this->request->get['filter_fullname'];
		}
		
		if (isset($this->request->get['filter_settle_status'])) {
			$url .= '&filter_settle_status=' . $this->request->get['filter_settle_status'];
		}
		
		if (isset($this->request->get['filter_apply_id'])) {
			$url .= '&filter_apply_id=' . $this->request->get['filter_apply_id'];
		}
		
		if (isset($this->request->get['filter_period_from'])) {
			$url .= '&filter_period_from=' . $this->request->get['filter_period_from'];
		}
		
		if (isset($this->request->get['filter_period_to'])) {
			$url .= '&filter_period_to=' . $this->request->get['filter_period_to'];
		}
		
		if (isset($this->request->get['filter_apply_date'])) {
			$url .= '&filter_apply_date=' . $this->request->get['filter_apply_date'];
		}

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
			'href' => $this->url->link('salesman/commissions_apply', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['applys'] = array();

		$filter_data = array(
			'filter_fullname'          => $filter_fullname,
			'filter_status'            => $filter_settle_status,
			'filter_apply_id'          => $filter_apply_id,
			'filter_period_from'       => $filter_period_from,
			'filter_period_to'         => $filter_period_to,
			'filter_apply_date'        => $filter_apply_date,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$apply_total = $this->model_salesman_commissions_apply->getTotalApplys($filter_data);
		
		$results = $this->model_salesman_commissions_apply->getCommissionApplys($filter_data);

		foreach ($results as $result) {
			$data['applys'][] = array(
				'apply_id'       	     => $result['apply_id'],
				'fullname'               => $result['fullname'],
				'period'       	         => date($this->language->get('date_format_short'), strtotime($result['period_from'])) . " - " . date($this->language->get('date_format_short'), strtotime($result['period_to'])),
				'commission_total'       => $result['commission_total'],
				'apply_date'             => $result['apply_date'],
				'status'                 => $result['status'],
				'payment_status'         => $result['status'] == 4 ? 1 : 0,
				'comments'               => $result['comments'],
				'edit'                   => $this->url->link('salesman/commissions_apply/edit', 'token=' . $this->session->data['token'] . '&apply_id=' . $result['apply_id'] . $url, 'SSL'),
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_settle_status_1'] = $this->language->get('text_settle_status_1');
		$data['text_settle_status_2'] = $this->language->get('text_settle_status_2');
		$data['text_settle_status_3'] = $this->language->get('text_settle_status_3');
		$data['text_settle_status_4'] = $this->language->get('text_settle_status_4');
		$data['text_settle_status_9'] = $this->language->get('text_settle_status_9');
		
		$data['text_payment_status_0'] = $this->language->get('text_payment_status_0');
		$data['text_payment_status_1'] = $this->language->get('text_payment_status_1');

		$data['column_action'] = $this->language->get("column_action");
		$data['column_apply_id'] = $this->language->get('column_apply_id');
		$data['column_fullname'] = $this->language->get('column_fullname');
		$data['column_period'] = $this->language->get('column_period');
		$data['column_commission_total'] = $this->language->get('column_commission_total');
		$data['column_apply_date'] = $this->language->get('column_apply_date');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_payment_status'] = $this->language->get('column_payment_status');
		$data['column_comments'] = $this->language->get('column_comments');

		$data['entry_fullname'] = $this->language->get('entry_fullname');
		$data['entry_settle_status'] = $this->language->get('entry_settle_status');
		$data['entry_apply_id'] = $this->language->get('entry_apply_id');
		$data['entry_period_from'] = $this->language->get('entry_period_from');
		$data['entry_period_to'] = $this->language->get('entry_period_to');
		$data['entry_apply_date'] = $this->language->get('entry_apply_date');

		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_edit'] = $this->language->get('button_edit');

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

		$url = '';

		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . $this->request->get['filter_fullname'];
		}
		
		if (isset($this->request->get['filter_settle_status'])) {
			$url .= '&filter_settle_status=' . $this->request->get['filter_settle_status'];
		}
		
		if (isset($this->request->get['filter_apply_id'])) {
			$url .= '&filter_apply_id=' . $this->request->get['filter_apply_id'];
		}
		
		if (isset($this->request->get['filter_period_from'])) {
			$url .= '&filter_period_from=' . $this->request->get['filter_period_from'];
		}
		
		if (isset($this->request->get['filter_period_to'])) {
			$url .= '&filter_period_to=' . $this->request->get['filter_period_to'];
		}
		
		if (isset($this->request->get['filter_apply_date'])) {
			$url .= '&filter_apply_date=' . $this->request->get['filter_apply_date'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_apply_id'] = $this->url->link('salesman/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=apply_id' . $url, 'SSL');
		$data['sort_period_from'] = $this->url->link('salesman/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=period_form' . $url, 'SSL');
		$data['sort_commission_total'] = $this->url->link('salesman/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=commission_total' . $url, 'SSL');
		$data['sort_apply_date'] = $this->url->link('salesman/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=apply_date' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('salesman/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_payment_status'] = $this->url->link('salesman/commission_totals_apply', 'token=' . $this->session->data['token'] . '&sort=payment_status' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . $this->request->get['filter_fullname'];
		}
		
		if (isset($this->request->get['filter_settle_status'])) {
			$url .= '&filter_settle_status=' . $this->request->get['filter_settle_status'];
		}
		
		if (isset($this->request->get['filter_apply_id'])) {
			$url .= '&filter_apply_id=' . $this->request->get['filter_apply_id'];
		}
		
		if (isset($this->request->get['filter_period_from'])) {
			$url .= '&filter_period_from=' . $this->request->get['filter_period_from'];
		}
		
		if (isset($this->request->get['filter_period_to'])) {
			$url .= '&filter_period_to=' . $this->request->get['filter_period_to'];
		}
		
		if (isset($this->request->get['filter_apply_date'])) {
			$url .= '&filter_apply_date=' . $this->request->get['filter_apply_date'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $apply_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('salesman/commissions_apply', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($apply_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($apply_total - $this->config->get('config_limit_admin'))) ? $apply_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $apply_total, ceil($apply_total / $this->config->get('config_limit_admin')));

		$data['filter_fullname'] = $filter_fullname;
		$data['filter_settle_status'] = $filter_settle_status;
		$data['filter_apply_id'] = $filter_apply_id;
		$data['filter_period_from'] = $filter_period_from;
		$data['filter_period_to'] = $filter_period_to;
		$data['filter_apply_date'] = $filter_apply_date;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('salesman/commissions_apply.tpl', $data));
	}

	/**
	 * 编辑某申请画面
	 */
	protected function getFrom() {
		// 取得相关申请信息
		if (isset($this->request->get['apply_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$application = $this->model_salesman_commissions_apply->getCommissionApply($this->request->get['apply_id']);
		} else {
			$application = '';
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = $this->language->get('text_form');
		$data['text_settle_status_1'] = $this->language->get('text_settle_status_1');
		$data['text_settle_status_2'] = $this->language->get('text_settle_status_2');
		$data['text_settle_status_3'] = $this->language->get('text_settle_status_3');
		$data['text_settle_status_4'] = $this->language->get('text_settle_status_4');
		$data['text_settle_status_9'] = $this->language->get('text_settle_status_9');
		
		$data['column_apply_id'] = $this->language->get('column_apply_id');
		$data['column_fullname'] = $this->language->get('column_fullname');
		$data['column_period'] = $this->language->get('column_period');
		$data['column_commission_total'] = $this->language->get('column_commission_total');
		$data['column_order_total'] = $this->language->get('column_order_total');
		$data['column_amount_total'] = $this->language->get('column_amount_total');
		$data['column_apply_date'] = $this->language->get('column_apply_date');
		$data['column_cancel_date'] = $this->language->get('column_cancel_date');
		$data['column_approve_date'] = $this->language->get('column_approve_date');
		$data['column_pay_date'] = $this->language->get('column_pay_date');
		$data['column_reject_date'] = $this->language->get('column_reject_date');
		$data['column_status_now'] = $this->language->get('column_status_now');
		
		$data['entry_settle_status'] = $this->language->get('entry_settle_status');
		$data['entry_comments'] = $this->language->get('entry_comments');
		
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save'] = $this->language->get('button_save');
		
		$url = '';
		
		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . $this->request->get['filter_fullname'];
		}
		
		if (isset($this->request->get['filter_settle_status'])) {
			$url .= '&filter_settle_status=' . $this->request->get['filter_settle_status'];
		}
		
		if (isset($this->request->get['filter_apply_id'])) {
			$url .= '&filter_apply_id=' . $this->request->get['filter_apply_id'];
		}
		
		if (isset($this->request->get['filter_period_from'])) {
			$url .= '&filter_period_from=' . $this->request->get['filter_period_from'];
		}
		
		if (isset($this->request->get['filter_period_to'])) {
			$url .= '&filter_period_to=' . $this->request->get['filter_period_to'];
		}
		
		if (isset($this->request->get['filter_apply_date'])) {
			$url .= '&filter_apply_date=' . $this->request->get['filter_apply_date'];
		}
		
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
				'href' => $this->url->link('salesman/commissions_apply', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['action'] = $this->url->link('salesman/commissions_apply/edit', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['cancel'] = $this->url->link('salesman/commissions_apply', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['token'] = $this->session->data['token'];
		
		if (!empty($application)) {
			$data['apply_id'] = $application['apply_id'];
			$data['fullname'] = $application['fullname'];
			$data['period'] = date($this->language->get('date_format_short'), strtotime($application['period_from'])) . " - " . date($this->language->get('date_format_short'), strtotime($application['period_to']));
			$data['order_total'] = $application['order_total'];
			$data['amount_total'] = $application['amount_total'];
			$data['commission_total'] = $application['commission_total'];
			$data['status'] = $application['status'];
			$data['apply_date'] = $application['apply_date'];
			$data['cancel_date'] = $application['cancel_date'];
			$data['approve_date'] = $application['approve_date'];
			$data['reject_date'] = $application['reject_date'];
			$data['pay_date'] = $application['pay_date'];
			$data['comments'] = $application['comments'];
		} else {
			$data['apply_id'] = '';
			$data['fullname'] = '';
			$data['period'] = '';
			$data['order_total'] = '';
			$data['amount_total'] = '';
			$data['commission_total'] = '';
			$data['status'] = '';
			$data['apply_date'] = '';
			$data['cancel_date'] = '';
			$data['approve_date'] = '';
			$data['reject_date'] = '';
			$data['pay_date'] = '';
			$data['comments'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('salesman/commissions_apply_form.tpl', $data));
	}

	/**
	 * 自动查找
	 */
	public function autocomplete() {
		$json = array();
	
		if (isset($this->request->get['filter_fullname'])) {
			if (isset($this->request->get['filter_fullname'])) {
				$filter_name = $this->request->get['filter_fullname'];
			} else {
				$filter_name = '';
			}
	
			$this->load->model('salesman/commissions_apply');
	
			$filter_data = array(
					'filter_name'  => $filter_name,
					'start'        => 0,
					'limit'        => 5
			);
	
			$results = $this->model_salesman_commissions_apply->getCommissionApplys($filter_data);
	
			foreach ($results as $result) {
				$json[] = array(
						'name'              => strip_tags(html_entity_decode($result['fullname'], ENT_QUOTES, 'UTF-8')),
				);
			}
		}
	
		$sort_order = array();
	
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}
	
		array_multisort($sort_order, SORT_ASC, $json);
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
}
