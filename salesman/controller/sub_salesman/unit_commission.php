<?php
/**
 * @author HU 
 */
class ControllerSubSalesmanUnitCommission extends Controller {
	private $error = array();
	
	/**
	 * 佣金设置一览画面
	 */
	public function index() {
		$this->load->language('sub_salesman/unit_commission');
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('sub_salesman/unit_commission');
	
		$this->getList();
	}
	
	/**
	 * 编辑（插入/更新）下级佣金信息
	 */
	public function edit() {
		$this->load->language('sub_salesman/unit_commission');
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('sub_salesman/unit_commission');
		
		if (isset($this->request->post['selected']) && $this->validateForm()) {
			foreach ($this->request->post['selected'] as $product_id) {
				if (isset($this->request->post['commissions']) && isset($this->request->post['commissions'][$product_id])) {
					$sub_commission['product_id'] = $product_id;
					$sub_commission['commission'] = $this->request->post['commissions'][$product_id]['sub_commission'];
					
					$this->model_sub_salesman_unit_commission->editProdCommission($sub_commission);
				}
			}
			
			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$this->getList();
	}

	/**
	 * 上级佣金显示和下级佣金设置画面
	 */
	protected function getList() {
		// 筛选条件
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
			'href' => $this->url->link('sub_salesman/unit_commission', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['edit'] = $this->url->link('sub_salesman/unit_commission/edit', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['products'] = array();

		$filter_data = array(
			'filter_name'              => $filter_name,
			'salesman_id'              => $this->salesman->getId(),
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$product_total = $this->model_sub_salesman_unit_commission->getTotalProducts($filter_data);

		$parent_results = $this->model_sub_salesman_unit_commission->getParentProdCommission($filter_data);
		
		$sub_results = $this->model_sub_salesman_unit_commission->getSubProdCommission($filter_data);

		foreach ($parent_results as $parent_result) {
			foreach ($sub_results as $sub_result) {
				if ($parent_result['product_id'] == $sub_result['product_id']) {
					$data['products'][] = array(
							'product_id'     => $parent_result['product_id'],
							'name'       	 => $parent_result['name'],
							'commission'     => $parent_result['commission'],
							'sub_commission' => $sub_result['commission']
					);
				}
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_product_id'] = $this->language->get('column_product_id');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_commission'] = $this->language->get('column_commission');
		$data['column_sub_commission'] = $this->language->get('column_sub_commission');

		$data['entry_name'] = $this->language->get('entry_name');

		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_edit'] = $this->language->get('button_edit');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['commission'])) {
			$data['error_commission'] = (array)$this->error['commission'];
		} else {
			$data['error_commission'] = '';
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
		
		if (isset($this->request->post['commissions'])) {
			$data['commissions'] = (array)$this->request->post['commissions'];
		} else {
			$data['commissions'] = array();
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

		$data['sort_product_id'] = $this->url->link('sub_salesman/unit_commission', 'token=' . $this->session->data['token'] . '&sort=product_id' . $url, 'SSL');
		$data['sort_name'] = $this->url->link('sub_salesman/unit_commission', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_commission'] = $this->url->link('sub_salesman/unit_commission', 'token=' . $this->session->data['token'] . '&sort=commission' . $url, 'SSL');

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
		$pagination->url = $this->url->link('sub_salesman/unit_commission', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sub_salesman/unit_commission.tpl', $data));
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
	
			$this->load->model('sub_salesman/unit_commission');
	
			$filter_data = array(
					'filter_name'  => $filter_name,
					'salesman_id'  => $this->salesman->getId(),
					'start'        => 0,
					'limit'        => 5
			);
	
			$results = $this->model_sub_salesman_unit_commission->getParentProdCommission($filter_data);
	
			foreach ($results as $result) {
				$json[] = array(
					'product_id'       => $result['product_id'],
					'name'             => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
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
	
	protected function validateForm() {
		
		foreach ($this->request->post['selected'] as $product_id) {
			if (isset($this->request->post['commissions']) && isset($this->request->post['commissions'][$product_id])) {
				
				if (!preg_match('/^(([0-9]+\\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\\.[0-9]+)|([0-9]*[1-9][0-9]*))$/', $this->request->post['commissions'][$product_id]['sub_commission'])
						|| ((int)$this->request->post['commissions'][$product_id]['sub_commission'] > (int)$this->request->post['commissions'][$product_id]['commission'])) {
							$this->error['commission'][$product_id] = $this->language->get('error_commission');
				}
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}
}
