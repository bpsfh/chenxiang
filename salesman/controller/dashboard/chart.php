<?php
class ControllerDashboardChart extends Controller {
	public function index() {
		$this->load->language('dashboard/chart');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_day'] = $this->language->get('text_day');
		$data['text_week'] = $this->language->get('text_week');
		$data['text_month'] = $this->language->get('text_month');
		$data['text_year'] = $this->language->get('text_year');
		$data['text_view'] = $this->language->get('text_view');

		$data['token'] = $this->session->data['token'];
		$data['salesman_id'] = $this->salesman->getId();

		return $this->load->view('dashboard/chart.tpl', $data);
	}

	public function chart() {
		$this->load->language('dashboard/chart');

		$json = array();
		
		$this->load->model('vip/order');
		$this->load->model('salesman/commission');

		$json['order']  = array();
		$json['sale']  = array();
		$json['commission']  = array();
		$json['xaxis']  = array();
		
		$json['order']['label'] = $this->language->get('text_order');
		$json['sale']['label'] = $this->language->get('text_sale');
		$json['commission']['label'] = $this->language->get('text_commission');
		
		$json['order']['data'] = array();
		$json['sale']['data'] = array();
		$json['commission']['data'] = array();
		
		$data = array();
		$data['salesman_id'] = $this->request->get['salesman_id'];
 
		if(empty($data["filter_date_end"])) {
			$data['filter_date_end'] = date('Y-m-d', time());
		}
		
		if(empty($data["filter_date_start"])) {
			$data['filter_date_start'] = date('Y-m-d', strtotime('-1 Month', strtotime($data['filter_date_end'])));
		}
		
		$results = $this->model_vip_order->getTotalOrdersByDate($data);
		
		foreach ($results as $key => $value) {
			$json['order']['data'][] = array($key, $value['total']);
		}
		
		$results = $this->model_vip_order->getTotalSalesByDate($data);

		foreach ($results as $key => $value) {
			$json['sale']['data'][] = array($key, $value['total']);
		}
		
		$results = $this->model_salesman_commission->getTotalCommissionsByDate($data);
		
		foreach ($results as $key => $value) {
			$json['commission']['data'][] = array($key, $value['total']);
		}
		
		for ($i = strtotime($data['filter_date_start']), $j = 0; $i <= strtotime($data['filter_date_end']);
			 $i = strtotime('+1 Day', $i), $j++) {
			$json['xaxis'][] = array($j, date('m-d', $i));
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
		
}
