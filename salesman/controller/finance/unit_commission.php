<?php
/**
 * @author jie-z 
 */
class ControllerFinanceUnitCommission extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('finance/unit_commission');
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('finance/unit_commission');

		$this->getList();
	}

	/**
	 * 
	 */
	protected function getList() {

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'product_id';
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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
			'href' => $this->url->link('finance/unit_commission', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['products'] = array();

		$filter_data = array(
			'filter_name'              => $filter_name,
			'salesman_id'              => $this->salesman->getId(),
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$product_total = $this->model_finance_unit_commission->getTotalProducts($filter_data);

		$results = $this->model_finance_unit_commission->getProductCommission($filter_data);

		foreach ($results as $result) {
						
			$data['products'][] = array(
				'product_id'     => $result['product_id'],
				'name'       	 => $result['name'],
				'commission'     => $result['commission'],
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_product_id'] = $this->language->get('column_product_id');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_commission'] = $this->language->get('column_commission');

		$data['entry_name'] = $this->language->get('entry_name');

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

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_product_id'] = $this->url->link('finance/unit_commission', 'token=' . $this->session->data['token'] . '&sort=product_id' . $url, 'SSL');
		$data['sort_name'] = $this->url->link('finance/unit_commission', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_commission'] = $this->url->link('finance/unit_commission', 'token=' . $this->session->data['token'] . '&sort=commission' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('finance/unit_commission', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('finance/unit_commission.tpl', $data));
	}

	/**
	 * 自动查找
	 */
	public function autocomplete() {
		$json = array();
	
		if (isset($this->request->get['filter_name'])) {
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
	
			$this->load->model('finance/unit_commission');
	
			$filter_data = array(
					'filter_name'  => $filter_name,
					'start'        => 0,
					'limit'        => 5
			);
	
			$results = $this->model_unit_commission->getUnitCommission($filter_data);
	
			foreach ($results as $result) {
				$json[] = array(
						'product_id'       => $result['product_id'],
						'name'              => strip_tags(html_entity_decode($result['fullname'], ENT_QUOTES, 'UTF-8')),
				);
			}
		}
	
		$sort_order = array();
	
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}
	
		array_multisort($sort_order, SORT_ASC, $json);
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
}
