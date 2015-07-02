<?php
class ControllerDashboardCommission extends Controller {
	public function index() {
		$this->load->language('dashboard/customer');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		$data['token'] = $this->session->data['token'];

		// Total Orders
//		$this->load->model('vip/customer');
		$this->load->model('vip/card');
		
//		$today = $this->model_vip_card->getTotalCustomers(array('filter_date_added' => date('Y-m-d', strtotime('-1 day'))));
//
//		$yesterday = $this->model_sale_customer->getTotalCustomers(array('filter_date_added' => date('Y-m-d', strtotime('-2 day'))));
//
//		$difference = $today - $yesterday;

		// Customers Online
		$customer_total = $this->model_vip_card->getBindedVipCards(array('salesman_id' => $this->salesman->getId()));
		/*		
		if ($customer_total > 1000000000000) {
			$data['total'] = round($customer_total / 1000000000000, 1) . 'T';
		} elseif ($customer_total > 1000000000) {
			$data['total'] = round($customer_total / 1000000000, 1) . 'B';
		} elseif ($customer_total > 1000000) {
			$data['total'] = round($customer_total / 1000000, 1) . 'M';
		} elseif ($customer_total > 1000) {
			$data['total'] = round($customer_total / 1000, 1) . 'K';
		} else {
			$data['total'] = $customer_total;
		}
		*/
	
		$data['total_formated'] = $this->currency->format($customer_total, $this->config->get('currency_code'));
	
		$data['percentage'] = $this->model_vip_card->getBindedRate(array('salesman_id' => $this->salesman->getId()));
		
		$data['customer'] = $this->url->link('vip/customer', 'token=' . $this->session->data['token'], 'SSL');

		return $this->load->view('dashboard/commission.tpl', $data);
	}
}
