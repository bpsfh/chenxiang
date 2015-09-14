<?php
/**
 * @author jie-z 
 */
class ControllerFinanceCommissionsApply extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('finance/commissions_apply');
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('finance/commissions_apply');

		$this->getList();
	}
	
	/**
	 * 提交申请
	 */
	public function apply() {
		$this->load->language('finance/commissions_apply');
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('finance/commissions_apply');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_finance_commissions_apply->apply($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$this->getList();
	}

	/**
	 * 下级结算申请一览
	 */
	protected function getList() {

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
			'href' => $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['settlements'] = array();

		$filter_data = array(
			'filter_status'            => $filter_settle_status,
			'filter_apply_id'          => $filter_apply_id,
			'filter_period_from'       => $filter_period_from,
			'filter_period_to'         => $filter_period_to,
			'salesman_id'              => $this->salesman->getId(),
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$results = $this->model_finance_commissions_apply->getSettlementsByMonth($filter_data);
		
		$apply_total = $this->model_finance_commissions_apply->getTotalSettlements($filter_data);

		$i = 0;
		
		foreach ($results as $result) {
			$i = $i + 1;
			$data['settlements'][] = array(
				'num'                    => $i,
				'apply_id'       	     => $result['apply_id'],
				'period'       	         => date($this->language->get('date_format_short'), strtotime($result['period_from'])) . " - " . date($this->language->get('date_format_short'), strtotime($result['period_to'])),
				'period_from'            => date($this->language->get('date_format_short'), strtotime($result['period_from'])),
				'period_to'              => date($this->language->get('date_format_short'), strtotime($result['period_to'])),
				'order_total'            => $result['order_total'],
				'amount_total'           => $result['amount_total'],
				'commission_total'       => $result['commission_total'],
				'apply_date'             => $result['apply_date'],
				'status'                 => $result['status'],
				'payment_status'         => $result['payment_status'],
				'comments'               => $result['comments'],
				'apply'                  => $this->url->link('finance/commissions_apply/apply', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_settle_status_0'] = $this->language->get('text_settle_status_0');
		$data['text_settle_status_1'] = $this->language->get('text_settle_status_1');
		$data['text_settle_status_2'] = $this->language->get('text_settle_status_2');
		$data['text_settle_status_3'] = $this->language->get('text_settle_status_3');
		$data['text_settle_status_4'] = $this->language->get('text_settle_status_4');
		$data['text_settle_status_9'] = $this->language->get('text_settle_status_9');
		
		$data['text_payment_status_0'] = $this->language->get('text_payment_status_0');
		$data['text_payment_status_1'] = $this->language->get('text_payment_status_1');

		$data['column_action'] = $this->language->get("column_action");
		$data['column_num'] = $this->language->get('column_num');
		$data['column_apply_id'] = $this->language->get('column_apply_id');
		$data['column_period'] = $this->language->get('column_period');
		$data['column_commission_total'] = $this->language->get('column_commission_total');
		$data['column_apply_date'] = $this->language->get('column_apply_date');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_payment_status'] = $this->language->get('column_payment_status');
		$data['column_comments'] = $this->language->get('column_comments');

		$data['entry_settle_status'] = $this->language->get('entry_settle_status');
		$data['entry_apply_id'] = $this->language->get('entry_apply_id');
		$data['entry_period_from'] = $this->language->get('entry_period_from');
		$data['entry_period_to'] = $this->language->get('entry_period_to');

		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_apply'] = $this->language->get('button_apply');

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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_apply_id'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=apply_id' . $url, 'SSL');
		$data['sort_period_from'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=period_form' . $url, 'SSL');
		$data['sort_commission_total'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=commission_total' . $url, 'SSL');
		$data['sort_apply_date'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=apply_date' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_payment_status'] = $this->url->link('finance/commission_totals_apply', 'token=' . $this->session->data['token'] . '&sort=payment_status' . $url, 'SSL');
		
		$url = '';

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
		$pagination->url = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($apply_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($apply_total - $this->config->get('config_limit_admin'))) ? $apply_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $apply_total, ceil($apply_total / $this->config->get('config_limit_admin')));

		$data['filter_settle_status'] = $filter_settle_status;
		$data['filter_apply_id'] = $filter_apply_id;
		$data['filter_period_from'] = $filter_period_from;
		$data['filter_period_to'] = $filter_period_to;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('finance/commissions_apply.tpl', $data));
	}
	
	/**
	 * 检查该时间段的数据是否已申请过
	 */
	protected function validateForm() {
		if (!empty($this->model_finance_commissions_apply->getApply($this->request->post))) {
			$this->error['apply_exist'] = $this->language->get('error_apply_exist');
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}
}
