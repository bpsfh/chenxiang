<?php
class ControllerDashboardMap extends Controller {
	public function index() {
		$this->load->language('dashboard/map');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_order'] = $this->language->get('text_order');
		$data['text_sale'] = $this->language->get('text_sale');

		$data['token'] = $this->session->data['token'];

		return $this->load->view('dashboard/map.tpl', $data);
	}

	public function map() {
		$json = array();
		
		$json['xaxis'] = array();
		$json['xaxis'][] = array(1, 1);
		$json['xaxis'][] = array(2, 2);
		$json['xaxis'][] = array(3, 3);
		$json['xaxis'][] = array(4, 4);
		$json['xaxis'][] = array(5, 5);
		$json['xaxis'][] = array(6, 6);
		$json['xaxis'][] = array(7, 7);

//		$this->load->model('report/sale');
//
//		$results = $this->model_report_sale->getTotalOrdersByCountry();
//
//		foreach ($results as $result) {
//			$json[strtolower($result['iso_code_2'])] = array(
//				'total'  => $result['total'],
//				'amount' => $this->currency->format($result['amount'], $this->config->get('currency_code'))
//			);
//		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}
}
