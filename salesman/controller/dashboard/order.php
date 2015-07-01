<?php
class ControllerDashboardOrder extends Controller {
	public function index() {
		$this->load->language('dashboard/order');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		$data['token'] = $this->session->data['token'];

		// Total Orders
		$this->load->model('vip/order');

		$order_total= $this->model_vip_order->getTotalVipOrdersCnt(array('salesman_id' => $this->salesman->getId()));

		if ($order_total > 1000000000000) {
			$data['total'] = round($order_total / 1000000000000, 1) . 'T';
		} elseif ($order_total > 1000000000) {
			$data['total'] = round($order_total / 1000000000, 1) . 'B';
		} elseif ($order_total > 1000000) {
			$data['total'] = round($order_total / 1000000, 1) . 'M';
		} elseif ($order_total > 1000) {
			$data['total'] = round($order_total / 1000, 1) . 'K';
		} else {
			$data['total'] = $order_total;
		}

		$data['order'] = $this->url->link('vip/order', 'token=' . $this->session->data['token'], 'SSL');

		return $this->load->view('dashboard/order.tpl', $data);
	}
}
