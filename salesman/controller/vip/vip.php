<?php
class ControllerVipVip extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('vip/vip');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('vip/card');

		$this->getList();
	}

	public function getList() {
		if (! $this->salesman->isLogged ()) {
			return new Action ( 'common/login' );
		}

		if (isset($this->request->get['filter_vip_card_num'])) {
			$filter_vip_card_num = $this->request->get['filter_vip_card_num'];
		} else {
			$filter_vip_card_num = null;
		}

		if (isset($this->request->get['filter_salesman_id'])) {
			$filter_salesman_id = $this->request->get['filter_salesman_id'];
		} else {
			$filter_salesman_id = null;
		}

		if (isset($this->request->get['filter_bind_status'])) {
			$filter_bind_status = $this->request->get['filter_bind_status'];
		} else {
			$filter_bind_status = null;
		}

		if (isset($this->request->get['filter_date_bind_to_salesman_fr'])) {
			$filter_date_bind_to_salesman_fr = $this->request->get['filter_date_bind_to_salesman_fr'];
		} else {
			$filter_date_bind_to_salesman_fr = null;
		}

		if (isset($this->request->get['filter_date_bind_to_salesman_to'])) {
			$filter_date_bind_to_salesman_to = $this->request->get['filter_date_bind_to_salesman_to'];
		} else {
			$filter_date_bind_to_salesman_to = null;
		}

		if (isset($this->request->get['filter_date_bind_to_customer_fr'])) {
			$filter_date_bind_to_customer_fr = $this->request->get['filter_date_bind_to_customer_fr'];
		} else {
			$filter_date_bind_to_customer_fr = null;
		}

		if (isset($this->request->get['filter_date_bind_to_customer_to'])) {
			$filter_date_bind_to_customer_to = $this->request->get['filter_date_bind_to_customer_to'];
		} else {
			$filter_date_bind_to_customer_to = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'vip_card_num';
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

		if (isset($this->request->get['filter_vip_card_num'])) {
			$url .= '&filter_vip_card_num=' . urlencode(html_entity_decode($this->request->get['filter_vip_card_num'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_salesman_id'])) {
			$url .= '&filter_salesman_id=' . urlencode(html_entity_decode($this->request->get['filter_salesman_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_bind_status'])) {
			$url .= '&filter_bind_status=' . urlencode(html_entity_decode($this->request->get['filter_bind_status'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_bind_to_salesman_fr'])) {
			$url .= '&filter_date_bind_to_salesman_fr=' . $this->request->get['filter_date_bind_to_salesman_fr'];
		}

		if (isset($this->request->get['filter_date_bind_to_salesman_to'])) {
			$url .= '&filter_date_bind_to_salesman_to=' . $this->request->get['filter_date_bind_to_salesman_to'];
		}

		if (isset($this->request->get['filter_date_bind_to_customer_fr'])) {
			$url .= '&filter_date_bind_to_customer_fr=' . $this->request->get['filter_date_bind_to_customer_fr'];
		}

		if (isset($this->request->get['filter_date_bind_to_customer_to'])) {
			$url .= '&filter_date_bind_to_customer_to=' . $this->request->get['filter_date_bind_to_customer_to'];
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
			'href' => $this->url->link('vip/vip', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$filter_data = array(
			'filter_vip_card_num'                => $filter_vip_card_num,
			'filter_salesman_id'                 => $filter_salesman_id,
			'filter_date_bind_to_salesman_fr'    => $filter_date_bind_to_salesman_fr,
			'filter_date_bind_to_salesman_to'    => $filter_date_bind_to_salesman_to,
			'filter_bind_status'                 => $filter_bind_status,
			'filter_date_bind_to_customer_fr'    => $filter_date_bind_to_customer_fr,
			'filter_date_bind_to_customer_to'    => $filter_date_bind_to_customer_to,
			'sort'                               => $sort,
			'order'                              => $order,
			'start'                              => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                              => $this->config->get('config_limit_admin')
		);

		$vips_total = $this->model_vip_card->getTotalVips($filter_data);

		$results = $this->model_vip_card->getVips($filter_data);

		foreach ($results as $key=>$result) {

			$data['vips'][] = array(
				'vip_card_id'              =>  $result['vip_card_id'],
				'num'                      => $key+1,
				'vip_card_num'             => $result['vip_card_num'],
				'salesman_id'              => $result['salesman_id'],
				'bind_status'              => $result['bind_status'],
				'bind_customer'            => $result['bind_customer'],
				'bind_customer_telephone'  => $result['bind_customer_telephone'],
				'date_bind_to_salesman'    => date($this->language->get('date_format_short'), strtotime($result['date_bind_to_salesman'])),
				'date_bind_to_customer'    => date($this->language->get('date_format_short'), strtotime($result['date_bind_to_customer'])),
				'activate_status'          => ((!is_null($result['bind_status'])) && (int)$result['bind_status'] === 1 ? true : false)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_send_vip'] = $this->language->get('text_send_vip');
		$data['text_send_vip_confirm'] = $this->language->get('text_send_vip_confirm');
		$data['text_send'] = $this->language->get('text_send');
		$data['text_invite_code'] = $this->language->get('text_invite_code');

		$data['text_bind_status_0'] = $this->language->get('text_bind_status_0');
		$data['text_bind_status_1'] = $this->language->get('text_bind_status_1');
		$data['text_bind_status_2'] = $this->language->get('text_bind_status_2');
		$data['text_bind_status_3'] = $this->language->get('text_bind_status_3');

		$data['column_num'] = $this->language->get('column_num');
		$data['column_vip_card_num'] = $this->language->get('column_vip_card_num');
		$data['column_salesman_id'] = $this->language->get('column_salesman_id');
		$data['column_bind_status'] = $this->language->get('column_bind_status');
		$data['column_bind_customer'] = $this->language->get('column_bind_customer');
		$data['column_date_bind_to_salesman'] = $this->language->get('column_date_bind_to_salesman');
		$data['column_date_bind_to_customer'] = $this->language->get('column_date_bind_to_customer');
		$data['column_bind_customer_telephone'] = $this->language->get('column_bind_customer_telephone');
		$data['column_activate_status'] = $this->language->get('column_activate_status');
		$data['column_generate_QR_code'] = $this->language->get('column_generate_QR_code');


		$data['entry_vip_card_num'] = $this->language->get('entry_vip_card_num');
		$data['entry_salesman_id'] = $this->language->get('entry_salesman_id');
		$data['entry_bind_status'] = $this->language->get('entry_bind_status');
		$data['entry_date_bind_to_salesman_fr'] = $this->language->get('entry_date_bind_to_salesman_fr');
		$data['entry_date_bind_to_salesman_to'] = $this->language->get('entry_date_bind_to_salesman_to');
		$data['entry_date_bind_to_customer_fr'] = $this->language->get('entry_date_bind_to_customer_fr');
		$data['entry_date_bind_to_customer_to'] = $this->language->get('entry_date_bind_to_customer_to');

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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_vip_card_num'])) {
			$url .= '&filter_vip_card_num=' . urlencode(html_entity_decode($this->request->get['filter_vip_card_num'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_salesman_id'])) {
			$url .= '&filter_salesman_id=' . urlencode(html_entity_decode($this->request->get['filter_salesman_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_bind_status'])) {
			$url .= '&filter_bind_status=' . urlencode(html_entity_decode($this->request->get['filter_bind_status'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_bind_to_salesman_fr'])) {
			$url .= '&filter_date_bind_to_salesman_fr=' . $this->request->get['filter_date_bind_to_salesman_fr'];
		}

		if (isset($this->request->get['filter_date_bind_to_salesman_to'])) {
			$url .= '&filter_date_bind_to_salesman_to=' . $this->request->get['filter_date_bind_to_salesman_to'];
		}

		if (isset($this->request->get['filter_date_bind_to_customer_fr'])) {
			$url .= '&filter_date_bind_to_customer_fr=' . $this->request->get['filter_date_bind_to_customer_fr'];
		}

		if (isset($this->request->get['filter_date_bind_to_customer_to'])) {
			$url .= '&filter_date_bind_to_customer_to=' . $this->request->get['filter_date_bind_to_customer_to'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

// 		$data['sort_num'] = $this->url->link('vip/vip', 'token=' . $this->session->data['token'] . '&sort=num' . $url, 'SSL');
		$data['sort_vip_card_num'] = $this->url->link('vip/vip', 'token=' . $this->session->data['token'] . '&sort=v.vip_card_num' . $url, 'SSL');
		$data['sort_salesman_id'] = $this->url->link('vip/vip', 'token=' . $this->session->data['token'] . '&sort=v.salesman_id' . $url, 'SSL');
		$data['sort_bind_status'] = $this->url->link('vip/vip', 'token=' . $this->session->data['token'] . '&sort=v.bind_status' . $url, 'SSL');
		$data['sort_bind_customer'] = $this->url->link('vip/vip', 'token=' . $this->session->data['token'] . '&sort=bind_customer' . $url, 'SSL');
		$data['sort_bind_customer_telephone'] = $this->url->link('vip/vip', 'token=' . $this->session->data['token'] . '&sort=bind_customer_telephone' . $url, 'SSL');
		$data['sort_date_bind_to_salesman'] = $this->url->link('vip/vip', 'token=' . $this->session->data['token'] . '&sort=v.date_bind_to_salesman' . $url, 'SSL');
		$data['sort_date_bind_to_customer'] = $this->url->link('vip/vip', 'token=' . $this->session->data['token'] . '&sort=v.date_bind_to_customer' . $url, 'SSL');
		$url = '';

		if (isset($this->request->get['filter_vip_card_num'])) {
			$url .= '&filter_vip_card_num=' . urlencode(html_entity_decode($this->request->get['filter_vip_card_num'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_salesman_id'])) {
			$url .= '&filter_salesman_id=' . urlencode(html_entity_decode($this->request->get['filter_salesman_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_bind_status'])) {
			$url .= '&filter_bind_status=' . urlencode(html_entity_decode($this->request->get['filter_bind_status'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_bind_to_salesman_fr'])) {
			$url .= '&filter_date_bind_to_salesman_fr=' . $this->request->get['filter_date_bind_to_salesman_fr'];
		}

		if (isset($this->request->get['filter_date_bind_to_salesman_to'])) {
			$url .= '&filter_date_bind_to_salesman_to=' . $this->request->get['filter_date_bind_to_salesman_to'];
		}

		if (isset($this->request->get['filter_date_bind_to_customer_fr'])) {
			$url .= '&filter_date_bind_to_customer_fr=' . $this->request->get['filter_date_bind_to_customer_fr'];
		}

		if (isset($this->request->get['filter_date_bind_to_customer_to'])) {
			$url .= '&filter_date_bind_to_customer_to=' . $this->request->get['filter_date_bind_to_customer_to'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $vips_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('vip/vip', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($vips_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($vips_total - $this->config->get('config_limit_admin'))) ? $vips_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $vips_total, ceil($vips_total / $this->config->get('config_limit_admin')));

		$data['filter_vip_card_num'] = $filter_vip_card_num;
		$data['filter_salesman_id'] = $filter_salesman_id;
		$data['filter_bind_status'] = $filter_bind_status;
		$data['filter_date_bind_to_salesman_fr'] = $filter_date_bind_to_salesman_fr;
		$data['filter_date_bind_to_salesman_to'] = $filter_date_bind_to_salesman_to;
		$data['filter_date_bind_to_customer_fr'] = $filter_date_bind_to_customer_fr;
		$data['filter_date_bind_to_customer_to'] = $filter_date_bind_to_customer_to;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('vip/vip_list.tpl', $data));
	}

	public function setVipStatus() {

		$json = array();

		$this->load->model('vip/card');

		$vip_card_id = $this->request->get['vip_card_id'];

		$this->model_vip_card->setVipStatus($vip_card_id);

		$json = array(
			'vip_card_id'  => $vip_card_id
		);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode ($json));
	}
}
