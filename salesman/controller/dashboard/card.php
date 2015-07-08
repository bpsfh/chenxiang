<?php
class ControllerDashboardCard extends Controller {
	public function index() {
		$this->load->language('dashboard/vipcard');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		$data['token'] = $this->session->data['token'];

		// Total Orders
		$this->load->model('vip/card');
		
		// Customers Online
		$data['card_count'] = $this->model_vip_card->getTotalVipCardsCnt(array('salesman_id' => $this->salesman->getId()));
		
		$data['vip_count'] = $this->model_vip_card->getBindedVipCardsCnt(array('salesman_id' => $this->salesman->getId()));

		$data['vip_link'] = $this->url->link('vip/card', 'token=' . $this->session->data['token'], 'SSL');

		return $this->load->view('dashboard/card.tpl', $data);
	}
}
