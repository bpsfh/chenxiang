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
	 * 下级结算申请一览
	 */
	protected function getList() {

		if (isset($this->request->get['filter_settle_status'])) {
			$filter_settle_status = $this->request->get['filter_settle_status'];
		} else {
			$filter_settle_status = null;
		}
		
		if (isset($this->request->get['filter_settlement_id'])) {
			$filter_settlement_id = $this->request->get['filter_settlement_id'];
		} else {
			$filter_settlement_id = null;
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
		
		if (isset($this->request->get['filter_settlement_id'])) {
			$url .= '&filter_settlement_id=' . $this->request->get['filter_settlement_id'];
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
			'href' => $this->url->link('finance/commission_apply', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['settlements'] = array();

		$filter_data = array(
			'filter_settle_status'     => $filter_settle_status,
			'filter_settlement_id'     => $filter_settlement_id,
			'filter_period_from'       => $filter_period_from,
			'filter_period_to'         => $filter_period_to,
			'salesman_id'              => $this->salesman->getId(),
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$product_total = $this->model_finance_commissions_apply->getTotalSettlements($filter_data);

		$results = $this->model_finance_commissions_apply->getSettlementsByMonth($filter_data);

		$i = 0;
		
		foreach ($results as $result) {
			$i = $i + 1;
			$data['settlements'][] = array(
				'num'                    => $i,
				'settlement_id'       	 => $result['apply_id'],
				'period'       	         => $result['period_from'] . "-" . $result['period_to'],
				'commission'             => $result['commission_total'],
				'apply_date'             => $result['apply_date'],
				'status'                 => $result['status'],
				'payment_status'         => $result['payment_status'],
				'comments'               => $result['comments']
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

		$data['column_num'] = $this->language->get('column_num');
		$data['column_settlement_id'] = $this->language->get('column_settlement_id');
		$data['column_period'] = $this->language->get('column_period');
		$data['column_commission'] = $this->language->get('column_commission');
		$data['column_apply_date'] = $this->language->get('column_apply_date');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_payment_status'] = $this->language->get('column_payment_status');
		$data['column_comments'] = $this->language->get('column_comments');

		$data['entry_settle_status'] = $this->language->get('entry_settle_status');
		$data['entry_settlement_id'] = $this->language->get('entry_settlement_id');
		$data['entry_period_from'] = $this->language->get('entry_period_from');
		$data['entry_period_to'] = $this->language->get('entry_period_to');

		$data['button_filter'] = $this->language->get('button_filter');

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
		
		if (isset($this->request->get['filter_settlement_id'])) {
			$url .= '&filter_settlement_id=' . $this->request->get['filter_settlement_id'];
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

		$data['settlement_id'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=settlement_id' . $url, 'SSL');
		$data['period'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=period' . $url, 'SSL');
		$data['commission'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=commission' . $url, 'SSL');
		$data['apply_date'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=apply_date' . $url, 'SSL');
		$data['status'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['payment_status'] = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . '&sort=payment_status' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_settle_status'])) {
			$url .= '&filter_settle_status=' . $this->request->get['filter_settle_status'];
		}
		
		if (isset($this->request->get['filter_settlement_id'])) {
			$url .= '&filter_settlement_id=' . $this->request->get['filter_settlement_id'];
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
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('finance/commissions_apply', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['filter_settle_status'] = $filter_settle_status;
		$data['filter_settlement_id'] = $filter_settlement_id;
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
	 * 自动查找
	 */
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
	
			$this->load->model('finance/unit_commission');
	
			$filter_data = array(
					'filter_name'  => $filter_name,
					'salesman_id'  => $this->salesman->getId(),
					'start'        => 0,
					'limit'        => 5
			);
	
			$results = $this->model_finance_unit_commission->getProductCommission($filter_data);
	
			foreach ($results as $result) {
				$json[] = array(
					'product_id'       => $result['product_id'],
					'name'             => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
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
