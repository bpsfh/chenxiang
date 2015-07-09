<?php
class ControllerVipOrder extends Controller {
	public function index() {
		$this->load->language('vip/order');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d');
		}

		if (isset($this->request->get['vip_card_id'])) {
			$vip_card_id = $this->request->get['vip_card_id'];
		} else {
			$vip_card_id = '';
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

		if (isset($this->request->get['vip_card_id'])) {
			$url .= '&vip_card_id=' . $this->request->get['vip_card_id'];
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
			'href' => $this->url->link('vip/order', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$this->load->model('vip/order');

		$data['orders'] = array();

		$filter_data = array(
			'salesman_id'		     => $this->salesman->getId(),
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
			'vip_card_id'                => $vip_card_id,
			'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                  => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_vip_order->getTotalOrders($filter_data);

		$results = $this->model_vip_order->getOrders($filter_data);

		foreach ($results as $result) {
			$data['orders'][] = array(
				'vip_card_id'   => $result['vip_card_id'], 
				'customer_id'   => $result['customer_id'],
				'order_id'      => $result['order_id'],
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'total'         => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'commission'    => $this->currency->format($result['commission'], $this->config->get('config_currency')),
				'settlement'	=> $this->language->get('text_settlement_not'), 
				'view'          => $this->url->link('vip/order', 'token=' . $this->session->data['token'] . '&vip_card_id=' . $result['vip_card_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_vip_card_id'] = $this->language->get('column_vip_card_id');
		$data['column_customer_id'] = $this->language->get('column_customer_id');
		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_commission'] = $this->language->get('column_commission');
		$data['column_settlement'] = $this->language->get('column_settlement');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_vip_card_id'] = $this->language->get('entry_vip_card_id');

		$data['button_filter'] = $this->language->get('button_filter');
                $data['button_view'] = $this->language->get('button_view');

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

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['vip_card_id'])) {
			$url .= '&vip_card_id=' . $this->request->get['vip_card_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('vip/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['vip_card_id'] = $vip_card_id;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('vip/order.tpl', $data));
	}
}
