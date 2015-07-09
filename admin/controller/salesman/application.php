<?php
/**
 * @author HU
 */
class ControllerSalesmanApplication extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('salesman/application');
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('salesman/user');
	
		$this->getList();
	}
	
	/**
	 * 业务员申请履历一览
	 */
	public function records() {
		$this->load->language('salesman/application');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('salesman/apply_record');
		
		$url = '';
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_date_first_applied'])) {
			$url .= '&filter_date_first_applied=' . $this->request->get['filter_date_first_applied'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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
				'href' => $this->url->link('salesman/application', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['records'] = array();
		
		
		if (isset($this->request->get['salesman_id'])) {
			$results = $this->model_salesman_apply_record->getRecords($this->request->get['salesman_id']);
			
			foreach ($results as $result) {
				$data['records'][] = array(
					'record_id'       => $result['record_id'],
					'salesman_id'     => $result['salesman_id'],
					'status'          => $result['status'],
					'reject_reason'   => $result['reject_reason'],
					'date_processed'  => $result['date_processed']
				);
			}
			
			$data['heading_title'] = $this->language->get('heading_title');
			
			$data['text_records_list'] = $this->language->get('text_records_list');
			$data['text_no_results'] = $this->language->get('text_no_results');
			
			$data['column_date_processed'] = $this->language->get('column_date_processed');
			$data['column_record_id'] = $this->language->get('column_record_id');
			$data['column_reject_reason'] = $this->language->get('column_reject_reason');
			$data['column_status'] = $this->language->get('column_status');
			
			$data['entry_status_0'] = $this->language->get('entry_status_0');
			$data['entry_status_1'] = $this->language->get('entry_status_1');
			$data['entry_status_2'] = $this->language->get('entry_status_2');
			$data['entry_status_3'] = $this->language->get('entry_status_3');
			$data['entry_status_4'] = $this->language->get('entry_status_4');
			
			$data['button_cancel'] = $this->language->get('button_cancel');
			
			$data['cancel'] = $this->url->link('salesman/application', 'token=' . $this->session->data['token'] . $url, 'SSL');
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('salesman/apply_records.tpl', $data));
			
		} else {
			$this->response->redirect($this->url->link('salesman/application', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
	}

	/**
	 * 业务员申请操作
	 */
	public function edit() {
		$this->load->language('salesman/application');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('salesman/user');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (isset($this->request->post['status']) && $this->request->post['status'] == '2') {
				$this->model_salesman_user->approve($this->request->post);
			} elseif (isset($this->request->post['status']) && $this->request->post['status'] == '3') {
				$this->model_salesman_user->reject($this->request->post);
			}
			
			$this->load->model('salesman/apply_record');
			$this->model_salesman_apply_record->insert($this->request->post);

			if (isset($this->request->post['status']) && $this->request->post['status'] == '2') {
				$this->session->data['success'] = $this->language->get('text_approve_success');
			} elseif (isset($this->request->post['status']) && $this->request->post['status'] == '3') {
				$this->session->data['success'] = $this->language->get('text_reject_success');
			}
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_date_first_applied'])) {
				$url .= '&filter_date_first_applied=' . $this->request->get['filter_date_first_applied'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			
			$this->response->redirect($this->url->link('salesman/application', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getFrom();
	}
	
	/**
	 * 业务员申请一览
	 */
	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}
		
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_date_first_applied'])) {
			$filter_date_first_applied = $this->request->get['filter_date_first_applied'];
		} else {
			$filter_date_first_applied = null;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'fullname';
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

		// 检索
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_date_first_applied'])) {
			$url .= '&filter_date_first_applied=' . $this->request->get['filter_date_first_applied'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			'href' => $this->url->link('salesman/application', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['applications'] = array();

		$filter_data = array(
			'filter_name'                => $filter_name,
			'filter_email'               => $filter_email,
			'filter_date_first_applied'  => $filter_date_first_applied,
			'filter_status'              => $filter_status,
			'sort'                       => $sort,
			'order'                      => $order,
			'start'                      => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                      => $this->config->get('config_limit_admin')
		);

		// 符合条件的总个数
		$application_total = $this->model_salesman_user->getTotalApplications($filter_data);

		$results = $this->model_salesman_user->getApplications($filter_data);

		foreach ($results as $result) {
			
			$data['applications'][] = array(
				'salesman_id'    	 => $result['salesman_id'],
				'fullname'       	 => $result['fullname'],
				'email'          	 => $result['email'],
				'date_first_applied' => $result['date_first_applied'],
				'status'         	 => $result['application_status'],
				'records'            => $this->url->link('salesman/application/records', 'token=' . $this->session->data['token'] . '&salesman_id=' . $result['salesman_id'] . $url, 'SSL'),
				'edit'               => $this->url->link('salesman/application/edit', 'token=' . $this->session->data['token'] . '&salesman_id=' . $result['salesman_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_status_1'] = $this->language->get('text_status_1');
		$data['text_status_2'] = $this->language->get('text_status_2');
		$data['text_status_3'] = $this->language->get('text_status_3');
		$data['text_status_4'] = $this->language->get('text_status_4');
		$data['text_status_5'] = $this->language->get('text_status_5');
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_salesman_id'] = $this->language->get('column_salesman_id');
		$data['column_fullname'] = $this->language->get('column_fullname');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_date_first_applied'] = $this->language->get('column_date_first_applied');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_fullname'] = $this->language->get('entry_fullname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_date_first_applied'] = $this->language->get('entry_date_first_applied');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['botton_records'] = $this->language->get('botton_records');
		$data['button_edit'] = $this->language->get('button_edit');
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

		// 排序
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_date_first_applied'])) {
			$url .= '&filter_date_first_applied=' . $this->request->get['filter_date_first_applied'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_fullname'] = $this->url->link('salesman/application', 'token=' . $this->session->data['token'] . '&sort=fullname' . $url, 'SSL');
		$data['sort_email'] = $this->url->link('salesman/application', 'token=' . $this->session->data['token'] . '&sort=email' . $url, 'SSL');
		$data['sort_date_first_applied'] = $this->url->link('salesman/application', 'token=' . $this->session->data['token'] . '&sort=date_first_applied' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('salesman/application', 'token=' . $this->session->data['token'] . '&sort=application_status' . $url, 'SSL');

		// 分页
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_date_first_applied'])) {
			$url .= '&filter_date_first_applied=' . $this->request->get['filter_date_first_applied'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $application_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('salesman/application', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($application_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($application_total - $this->config->get('config_limit_admin'))) ? $application_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $application_total, ceil($application_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_email'] = $filter_email;
		$data['filter_date_first_applied'] = $filter_date_first_applied;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('salesman/application_list.tpl', $data));
	}

	/**
	 * 审核画面
	 */
	protected function getFrom() {
		// 取得相关申请信息
		if (isset($this->request->get['salesman_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$application = $this->model_salesman_user->getApplication($this->request->get['salesman_id']);
		} else {
			$application = '';
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = $this->language->get('text_form');
		$data['text_apply_status_2'] = $this->language->get('text_apply_status_2');
		$data['text_apply_status_3'] = $this->language->get('text_apply_status_3');
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_reject_reason'] = $this->language->get('entry_reject_reason');
		
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_commit'] = $this->language->get('button_commit');
		
		$url = '';
			
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
			
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
			
		if (isset($this->request->get['filter_date_first_applied'])) {
			$url .= '&filter_date_first_applied=' . $this->request->get['filter_date_first_applied'];
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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
				'href' => $this->url->link('salesman/application', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['action'] = $this->url->link('salesman/application/edit', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['cancel'] = $this->url->link('salesman/application', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['token'] = $this->session->data['token'];
		
		if (!empty($application)) {
			$data['salesman_id'] = $application['salesman_id'];
		} else {
			$data['salesman_id'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('salesman/application_form.tpl', $data));
	}
	
	/**
	 * 自动查找
	 */
	public function autocomplete() {
		$json = array();
	
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_email'])) {
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
	
			if (isset($this->request->get['filter_email'])) {
				$filter_email = $this->request->get['filter_email'];
			} else {
				$filter_email = '';
			}
	
			$this->load->model('salesman/user');
	
			$filter_data = array(
					'filter_name'  => $filter_name,
					'filter_email' => $filter_email,
					'start'        => 0,
					'limit'        => 5
			);
	
			$results = $this->model_salesman_user->getApplications($filter_data);
	
			foreach ($results as $result) {
				$json[] = array(
						'salesman_id'       => $result['salesman_id'],
						'name'              => strip_tags(html_entity_decode($result['fullname'], ENT_QUOTES, 'UTF-8')),
						'email'             => $result['email'],
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