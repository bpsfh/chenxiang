<?php
class ControllerDashboardAchievement extends Controller {
	public function index() {
		$this->load->language('dashboard/achievement');

		$data['heading_title_commission'] = $this->language->get('heading_title_commission');
		$data['heading_title_customer'] = $this->language->get('heading_title_customer');
		$data['heading_title_order'] = $this->language->get('heading_title_order');
		$data['heading_title_sale'] = $this->language->get('heading_title_sale');
		$data['heading_title_chart'] = $this->language->get('heading_title_chart');

		$data['entry_period_from'] = $this->language->get('entry_period_from');
		$data['entry_period_to'] = $this->language->get('entry_period_to');
		$data['button_filter'] = $this->language->get('button_filter');


		$data['text_view'] = $this->language->get('text_view');

		$data['token'] = $this->session->data['token'];

		// Filter
		if (isset($this->request->get['filter_period_from'])) {
			$filter_period_from = $this->request->get['filter_period_from'];
		} else {
			$filter_period_from= null;    //date("Y-m-d", strtotime("-1 months"));
		}
		
		if (isset($this->request->get['filter_period_to'])) {
			$filter_period_to = $this->request->get['filter_period_to'];
		} else {
			$filter_period_to = null;    //date("Y-m-d");
		}

		// Total Commissions 
		$this->load->model('finance/commissions_apply');

		$filter_data = array(
			'filter_period_from'       => $filter_period_from,
			'filter_period_to'         => $filter_period_to,
			'salesman_id'              => $this->salesman->getId()
		);

		$results = $this->model_finance_commissions_apply->getSettlementsByMonth($filter_data);

		$commission_sum = 0;
		$order_sum = 0;
		$sale_sum = 0;

		foreach ($results as $result) {
			$data['settlements'][] = array(
				'settlement_id'       	 => $result['apply_id'],
				'period'       	         => $result['period_from'] . "-" . $result['period_to'],
				'commission_total'       => $result['commission_total'],
				'order_total'            => $result['order_total'],
				'sale_total'             => $result['amount_total']
			);

			$commission_sum = $commission_sum + $result['commission_total'];
			$order_sum = $order_sum + $result['order_total'];
			$sale_sum = $sale_sum + $result['amount_total'];
		}

		$data['total_formated_commission'] = $this->currency->format($commission_sum, $this->config->get('currency_code'));
		$data['total_formated_sale'] = $this->currency->format($sale_sum, $this->config->get('currency_code'));
		$data['total_order'] = $order_sum;

		// Get VIP information.
		$this->load->model('vip/card');
		$customer_total = $this->model_vip_card->getBindedVipCardsCnt($filter_data);
		
		if ($customer_total > 1000000000000) {
			$data['total_vip'] = round($customer_total / 1000000000000, 1) . 'T';
		} elseif ($customer_total > 1000000000) {
			$data['total_vip'] = round($customer_total / 1000000000, 1) . 'B';
		} elseif ($customer_total > 1000000) {
			$data['total_vip'] = round($customer_total / 1000000, 1) . 'M';
		} elseif ($customer_total > 1000) {
			$data['total_vip'] = round($customer_total / 1000, 1) . 'K';
		} else {
			$data['total_vip'] = $customer_total;
		}
		
		$data['total_card'] = $this->model_vip_card->getTotalVipCardsCnt($filter_data);
	
		// Links
		$param = 'token=' . $this->session->data['token'] . '&filter_date_start=' . $filter_period_from . '&filter_date_end=' . $filter_period_to;
		$data['commission'] = $this->url->link('finance/order_commissions', $param, 'SSL');
		$data['customer'] = $this->url->link('vip/customer', $param, 'SSL');
		$data['order'] = $this->url->link('vip/order', $param, 'SSL');
		$data['sale'] = $this->url->link('vip/order', $param, 'SSL');

		return $this->load->view('dashboard/achievement.tpl', $data);
	}
}
