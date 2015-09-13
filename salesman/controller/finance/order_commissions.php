<?php
class ControllerFinanceOrderCommissions extends Controller {
	public function index() {
		$this->load->language('finance/order_commissions');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = null ;
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = null ;
		}

		if (isset($this->request->get['filter_commissions_status'])) {
			$filter_commissions_status = $this->request->get['filter_commissions_status'];
		} else {
			$filter_commissions_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'date';
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

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_commissions_status'])) {
			$url .= '&filter_commissions_status=' . $this->request->get['filter_commissions_status'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_date'] = $this->url->link('finance/order_commissions', 'token=' . $this->session->data['token'] . '&sort=date' . $url, 'SSL');
		$data['sort_order_num'] = $this->url->link('finance/order_commissions', 'token=' . $this->session->data['token'] . '&sort=order_num' . $url, 'SSL');
		$data['sort_order_total'] = $this->url->link('finance/order_commissions', 'token=' . $this->session->data['token'] . '&sort=order_total' . $url, 'SSL');
		$data['sort_commissions_total'] = $this->url->link('finance/order_commissions', 'token=' . $this->session->data['token'] . '&sort=commissions_total' . $url, 'SSL');
		$data['sort_commissions_status'] = $this->url->link('finance/order_commissions', 'token=' . $this->session->data['token'] . '&sort=commissions_status' . $url, 'SSL');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('finance/order_commissions', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$this->load->model('finance/order_commissions');

		$data['orders'] = array();

		$filter_data = array(
			'salesman_id'		     => $this->salesman->getId(),
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
			'filter_commissions_status'  => $filter_commissions_status,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                  => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_finance_order_commissions->getTotalOrderCommissions($filter_data);

		$results = $this->model_finance_order_commissions->getOrderCommissions($filter_data);
		if (!empty($results)) {
			foreach ($results as $key=>$result) {
				$data['commissions'][] = array(
					'num'                 => $key+1,
					'commissions_status'  => (!is_null($result['commissions_status'])? 1: 0),
					'order_num'           => $result['order_num'],
 					'order_total'         => $this->currency->format($result['order_total'], $this->config->get('config_currency')),
					'commissions_total'   => $this->currency->format($result['commissions_total'], $this->config->get('config_currency')),
					'date'                => date($this->language->get('date_format_short'), strtotime($result['date'])),
				);
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_commissions_status_0'] = $this->language->get('text_commissions_status_0');
		$data['text_commissions_status_1'] = $this->language->get('text_commissions_status_1');

		$data['column_num'] = $this->language->get('column_num');
		$data['column_date'] = $this->language->get('column_date');
		$data['column_order_num'] = $this->language->get('column_order_num');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_order_total'] = $this->language->get('column_order_total');
		$data['column_commissions_total'] = $this->language->get('column_commissions_total');
		$data['column_commissions_status'] = $this->language->get('column_commissions_status');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_commissions_status'] = $this->language->get('entry_commissions_status');

		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_commissions_status'])) {
			$url .= '&filter_commissions_status=' . $this->request->get['filter_commissions_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('finance/order_commissions', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_commissions_status'] = $filter_commissions_status;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('finance/order_commissions_list.tpl', $data));
	}
}
