<?php
/**
 * @author HU
 */
class ControllerSalesmanVipCard extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('salesman/vip_card');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('salesman/vip_card_application');
		
		$this->getList();
	}
	
	/**
	 * 拒绝VIP卡的申请
	 */
	public function reject() {
		$this->load->language('salesman/vip_card');

		$this->document->setTitle($this->language->get('reject_heading_title'));
		
		$this->load->model('salesman/vip_card_application');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_salesman_vip_card_application->rejectApplication($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_reject_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_fullname'])) {
				$url .= '&filter_fullname=' . urlencode(html_entity_decode($this->request->get['filter_fullname'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_date_applied'])) {
				$url .= '&filter_date_applied=' . urlencode(html_entity_decode($this->request->get['filter_date_applied'], ENT_QUOTES, 'UTF-8'));
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
			
			$this->response->redirect($this->url->link('salesman/vip_card', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getForm();
	}

	/**
	 * 批准VIP卡申请
	 */
	public function approve() {
		$this->load->language('salesman/vip_card');
		
		$this->load->model('salesman/vip_card_application');
		$this->load->model('salesman/vip_card');
		
		$url = '';
			
		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . urlencode(html_entity_decode($this->request->get['filter_fullname'], ENT_QUOTES, 'UTF-8'));
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
		}
			
		if (isset($this->request->get['filter_date_applied'])) {
			$url .= '&filter_date_applied=' . urlencode(html_entity_decode($this->request->get['filter_date_applied'], ENT_QUOTES, 'UTF-8'));
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
		
		if (isset($this->request->get['apply_id'])) {
			$application = $this->model_salesman_vip_card_application->getApplication($this->request->get['apply_id']);
			
			if (!empty($application)) {
				$apply_qty = $application['apply_qty'];
				
				// 生成申请个数的邀请码，与申请的业务员绑定，插入数据库中
				for ($i = 0; $i < $apply_qty; $i++) {
					$vip_card['vip_card_num'] = strtoupper(substr(md5(uniqid(rand(),1)), 8, 16));
					$vip_card['salesman_id'] = $application['salesman_id'];
					
					$this->model_salesman_vip_card->addVipCard($vip_card);
				}
				
				// 更新申请表
				$this->model_salesman_vip_card_application->approveApplication($this->request->get['apply_id']);
				
				$this->session->data['success'] = $this->language->get('text_approve_success');
			} else {
				$this->session->data['warning'] = $this->language->get('text_error_not_exist');
			}
		}
			
		$this->response->redirect($this->url->link('salesman/vip_card', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}
	
	/**
	 * VIP卡申请一览表
	 */
	public function getList() {
		// 筛选条件-业务员名
		if (isset($this->request->get['filter_fullname'])) {
			$filter_fullname = $this->request->get['filter_fullname'];
		} else {
			$filter_fullname = null;
		}
		
		// 筛选条件-处理状态
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		
		// 筛选条件-申请日期
		if (isset($this->request->get['filter_date_applied'])) {
			$filter_date_applied = $this->request->get['filter_date_applied'];
		} else {
			$filter_date_applied = null;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'date_applied';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
		
		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . urlencode(html_entity_decode($this->request->get['filter_fullname'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_date_applied'])) {
			$url .= '&filter_date_applied=' . urlencode(html_entity_decode($this->request->get['filter_date_applied'], ENT_QUOTES, 'UTF-8'));
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
				'href' => $this->url->link('salesman/vip_card', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$filter_data = array(
			'filter_fullname'   => $filter_fullname,
			'filter_status'     => $filter_status,
			'filter_date_applied'	=> $filter_date_applied,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'             => $this->config->get('config_limit_admin')
		);
		
		$application_total = $this->model_salesman_vip_card_application->getTotalApplications($filter_data);
		
		$results = $this->model_salesman_vip_card_application->getApplicationLists($filter_data);
		
		$data['applications'] = array();
		
		foreach ($results as $result) {
			if ($result['apply_status'] == 0) {
				$approve = $this->url->link('salesman/vip_card/approve', 'token=' . $this->session->data['token'] . '&apply_id=' . $result['apply_id'] . $url, 'SSL');
				$reject = $this->url->link('salesman/vip_card/reject', 'token=' . $this->session->data['token'] . '&apply_id=' . $result['apply_id'] . $url, 'SSL');
			} elseif ($result['apply_status'] == 1) {
				$approve = '';
				$reject = '';
			} else {
				$approve = '';
				$reject = $this->url->link('salesman/vip_card/reject', 'token=' . $this->session->data['token'] . '&apply_id=' . $result['apply_id'] . $url, 'SSL');
			}
			
			$data['applications'][] = array(
				'apply_id'       => $result['apply_id'],
				'salesman_id'    => $result['salesman_id'],
				'fullname'       => $result['fullname'],
				'apply_qty'      => $result['apply_qty'],
				'date_applied'     => $result['date_applied'],
				'apply_reason'   => $result['apply_reason'],
				'apply_status'   => $result['apply_status'],
				'date_processed' => $result['date_processed'],
				'reject_reason'  => $result['reject_reason'],
				'approve'        => $approve,
				'reject'         => $reject
			);
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		
		$data['column_apply_id'] = $this->language->get('column_apply_id');
		$data['column_salesman_id'] = $this->language->get('column_salesman_id');
		$data['column_fullname'] = $this->language->get('column_fullname');
		$data['column_apply_qty'] = $this->language->get('column_apply_qty');
		$data['column_date_applied'] = $this->language->get('column_date_applied');
		$data['column_apply_reason'] = $this->language->get('column_apply_reason');
		$data['column_apply_status'] = $this->language->get('column_apply_status');
		$data['column_date_processed'] = $this->language->get('column_date_processed');
		$data['column_reject_reason'] = $this->language->get('column_reject_reason');
		$data['column_action'] = $this->language->get('column_action');
		
		$data['entry_fullname'] = $this->language->get('entry_fullname');
		$data['entry_date_applied'] = $this->language->get('entry_date_applied');
		$data['entry_apply_status'] = $this->language->get('entry_apply_status');
		$data['entry_apply_status_0'] = $this->language->get('entry_apply_status_0');
		$data['entry_apply_status_1'] = $this->language->get('entry_apply_status_1');
		$data['entry_apply_status_2'] = $this->language->get('entry_apply_status_2');
		
		$data['button_filter'] = $this->language->get('button_filter');
		$data['botton_approve'] = $this->language->get('botton_approve');
		$data['botton_reject'] = $this->language->get('botton_reject');
		
		$data['token'] = $this->session->data['token'];
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];
			
			unset($this->session->data['warning']);
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
		
		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . urlencode(html_entity_decode($this->request->get['filter_fullname'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_date_applied'])) {
			$url .= '&filter_date_applied=' . urlencode(html_entity_decode($this->request->get['filter_date_applied'], ENT_QUOTES, 'UTF-8'));
		}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_fullname'] = $this->url->link('salesman/vip_card', 'token=' . $this->session->data['token'] . '&sort=s.fullname' . $url, 'SSL');
		$data['sort_apply_id'] = $this->url->link('salesman/vip_card', 'token=' . $this->session->data['token'] . '&sort=apply_id' . $url, 'SSL');
		$data['sort_date_applied'] = $this->url->link('salesman/vip_card', 'token=' . $this->session->data['token'] . '&sort=date_applied' . $url, 'SSL');
		$data['sort_date_processed'] = $this->url->link('salesman/vip_card', 'token=' . $this->session->data['token'] . '&sort=date_processed' . $url, 'SSL');
		
		// 分页
		$url = '';
		
		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . urlencode(html_entity_decode($this->request->get['filter_fullname'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_date_applied'])) {
			$url .= '&filter_date_applied=' . urlencode(html_entity_decode($this->request->get['filter_date_applied'], ENT_QUOTES, 'UTF-8'));
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
		$pagination->url = $this->url->link('salesman/vip_card', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($application_total) ? (($page - 1) * $this->config->get('config_limit_admin'))
				 + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($application_total - $this->config->get('config_limit_admin'))) ? $application_total : ((($page - 1) * $this->config->get('config_limit_admin'))
				 		 + $this->config->get('config_limit_admin')), $application_total, ceil($application_total / $this->config->get('config_limit_admin')));
		
		$data['filter_fullname'] = $filter_fullname;
		$data['filter_status'] = $filter_status;
		$data['filter_date_applied'] = $filter_date_applied;
		
		$data['sort'] = $sort;
		$data['order'] = $order;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('salesman/vip_card_application_list.tpl', $data));
	}

	/**
	 * 拒绝申请画面
	 */
	public function getForm() {
		// 取得相关申请信息
		if (isset($this->request->get['apply_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$application = $this->model_salesman_vip_card_application->getApplication($this->request->get['apply_id']);
		} else {
			$application = '';
		}
		
		$data['heading_title'] = $this->language->get('reject_heading_title');
	
		$data['text_form'] = $this->language->get('text_reject');
		
		$data['entry_apply_id'] = $this->language->get('entry_apply_id');
		$data['entry_salesman_id'] = $this->language->get('entry_salesman_id');
		$data['entry_fullname'] = $this->language->get('entry_fullname');
		$data['entry_apply_qty'] = $this->language->get('entry_apply_qty');
		$data['entry_date_applied'] = $this->language->get('entry_date_applied');
		$data['entry_apply_reason'] = $this->language->get('entry_apply_reason');
		$data['entry_apply_status'] = $this->language->get('entry_apply_status');
		$data['entry_last_date_processed'] = $this->language->get('entry_last_date_processed');
		$data['entry_reject_reason'] = $this->language->get('entry_reject_reason');
		$data['entry_apply_status'] = $this->language->get('entry_apply_status');
		$data['entry_apply_status_0'] = $this->language->get('entry_apply_status_0');
		$data['entry_apply_status_1'] = $this->language->get('entry_apply_status_1');
		$data['entry_apply_status_2'] = $this->language->get('entry_apply_status_2');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$url = '';
		
		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . urlencode(html_entity_decode($this->request->get['filter_fullname'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_date_applied'])) {
			$url .= '&filter_date_applied=' . urlencode(html_entity_decode($this->request->get['filter_date_applied'], ENT_QUOTES, 'UTF-8'));
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
				'href' => $this->url->link('salesman/vip_card', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['action'] = $this->url->link('salesman/vip_card/reject', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['cancel'] = $this->url->link('salesman/vip_card', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['token'] = $this->session->data['token'];
		
		if (!empty($application)) {
			$data['apply_id'] = $application['apply_id'];
			$data['salesman_id'] = $application['salesman_id'];
			$data['fullname'] = $application['fullname'];
			$data['apply_qty'] = $application['apply_qty'];
			$data['date_applied'] = $application['date_applied'];
			$data['apply_reason'] = $application['apply_reason'];
			$data['apply_status'] = $application['apply_status'];
			$data['date_processed'] = $application['date_processed'];
			$data['reject_reason'] = $application['reject_reason'];
		} else {
			$data['apply_id'] = '';
			$data['salesman_id'] = '';
			$data['fullname'] = '';
			$data['apply_qty'] = '';
			$data['date_applied'] = '';
			$data['apply_reason'] = '';
			$data['apply_status'] = '';
			$data['date_processed'] = '';
			$data['reject_reason'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('salesman/vip_card_application_form.tpl', $data));
	}
	
	/**
	 * 根据输入业务员名，将符合条件的业务员名显示
	 * 为用户提供参考
	 */
	public function autocomplete() {
		$json = array();
	
		if (isset($this->request->get['filter_fullname'])) {
			if (isset($this->request->get['filter_fullname'])) {
				$filter_fullname = $this->request->get['filter_fullname'];
			} else {
				$filter_fullname = '';
			}
	
			$this->load->model('salesman/vip_card_application');
	
			$filter_data = array(
					'filter_name'  => $filter_fullname,
					'start'        => 0,
					'limit'        => 5
			);
	
			$results = $this->model_salesman_vip_card_application->getSalesmans($filter_data);
	
			foreach ($results as $result) {
				$json[] = array(
						'salesman_id'       => $result['salesman_id'],
						'fullname'         => $result['fullname']
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