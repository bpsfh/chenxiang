<?php
class ControllerDashboardCommission extends Controller {
	public function index() {
		$this->load->language('dashboard/commission');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		$data['token'] = $this->session->data['token'];

		// Total Commissions 
		$this->load->model('salesman/commission');
		
		// Customers Online
		$commission_total = $this->model_salesman_commission->getCommissions(array('salesman_id' => $this->salesman->getId()));

		$data['total_formated'] = $this->currency->format($commission_total, $this->config->get('currency_code'));
	
		$data['percentage'] = 0;
		
		$data['customer'] = $this->url->link('vip/order', 'token=' . $this->session->data['token'], 'SSL');

		return $this->load->view('dashboard/commission.tpl', $data);
	}
}
