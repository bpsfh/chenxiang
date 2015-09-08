<?php
class ControllerSalesmanUpload extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('salesman/upload');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('salesman/upload');

		$this->getList();
	}

	public function delete() {
		$this->load->language('salesman/upload');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('salesman/upload');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $upload_id) {
				$this->model_salesman_upload->deleteUpload($upload_id);
			}

			$this->session->data['success'] = $this->language->get('text_success_delete');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('salesman/upload', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_filename'])) {
			$filter_filename = $this->request->get['filter_filename'];
		} else {
			$filter_filename = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['filter_salesman'])) {
			$filter_salesman = $this->request->get['filter_salesman'];
		} else {
			$filter_salesman = null;
		}
		if (isset($this->request->get['filter_salesman_son'])) {
			$filter_salesman_son = $this->request->get['filter_salesman_son'];
		} else {
			$filter_salesman_son = '0';
		}
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'dd.name';
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

		if (isset($this->request->get['filter_filename'])) {
			$url .= '&filter_filename=' . urlencode(html_entity_decode($this->request->get['filter_filename'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_salesman'])) {
			$url .= '&filter_salesman=' . urlencode(html_entity_decode($this->request->get['filter_salesman'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_salesman_son'])) {
			$url .= '&filter_salesman_son=' . $this->request->get['filter_salesman_son'];
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
			'href' => $this->url->link('salesman/upload', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('salesman/upload/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('salesman/upload/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['uploads'] = array();

		$filter_data = array(
			'filter_name'	    => $filter_name,
			'filter_filename'   => $filter_filename,
			'filter_date_added'	=> $filter_date_added,
			'filter_salesman'   => $filter_salesman,
			'filter_salesman_son'=> $filter_salesman_son,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$upload_total = $this->model_salesman_upload->getTotalUploads($filter_data);

		$results = $this->model_salesman_upload->getUploads($filter_data);

		foreach ($results as $result) {

			$data['uploads'][] = array(
				'upload_id'   => $result['upload_id'],
				'name'        => $result['name'],
				'filename'    => $result['filename'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'download'    => $this->url->link('salesman/upload/download', 'token=' . $this->session->data['token'] . '&mask=' . $result['mask'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_salesman_son_yes'] = $this->language->get('text_salesman_son_yes');
		$data['text_salesman_son_no'] = $this->language->get('text_salesman_son_no');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_filename'] = $this->language->get('column_filename');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_filename'] = $this->language->get('entry_filename');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_salesman'] = $this->language->get('entry_salesman');
		$data['entry_salesman_son'] = $this->language->get('entry_salesman_son');


		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_download'] = $this->language->get('button_download');

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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('salesman/upload', 'token=' . $this->session->data['token'] . '&sort=dd.name' . $url, 'SSL');
		$data['sort_filename'] = $this->url->link('salesman/upload', 'token=' . $this->session->data['token'] . '&sort=filename' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('salesman/upload', 'token=' . $this->session->data['token'] . '&sort=d.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_filename'])) {
			$url .= '&filter_filename=' . urlencode(html_entity_decode($this->request->get['filter_filename'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_salesman'])) {
			$url .= '&filter_salesman=' . urlencode(html_entity_decode($this->request->get['filter_salesman'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_salesman_son'])) {
			$url .= '&filter_salesman_son=' . urlencode(html_entity_decode($this->request->get['filter_salesman_son'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		$data['token'] = $this->session->data['token'];

		$pagination = new Pagination();
		$pagination->total = $upload_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('salesman/upload', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($upload_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($upload_total - $this->config->get('config_limit_admin'))) ? $upload_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $upload_total, ceil($upload_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['filter_name'] = $filter_name;
		$data['filter_filename'] = $filter_filename;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_salesman'] = $filter_salesman;
		$data['filter_salesman_son'] = $filter_salesman_son;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('salesman/upload_list.tpl', $data));
	}

	public function download() {
		$this->load->model('salesman/upload');

		if (isset($this->request->get['mask'])) {
			$mask = $this->request->get['mask'];
		} else {
			$mask = 0;
		}

		$upload_info = $this->model_salesman_upload->getUploadByMask($mask);

		if ($upload_info) {
			$file = DIR_UPLOAD . $upload_info['filename'];
			if (!headers_sent()) {
				if (is_file($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file, 'rb');
					exit;
				} else {
					exit('Error: Could not find file ' . $file . '!');
				}
			} else {
				exit('Error: Headers already sent out!');
			}
		} else {
			$this->load->language('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_not_found'] = $this->language->get('text_not_found');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
					'text' => $this->language->get('text_home'),
					'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['breadcrumbs'][] = array(
					'text' => $this->language->get('heading_title'),
					'href' => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('error/not_found.tpl', $data));
		}
	}


	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_filename'])) {
			$this->load->model('salesman/upload');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'filter_filename' => $this->request->get['filter_filename'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_salesman_upload->getUploads($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'upload_id' => $result['upload_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'filename'        => strip_tags(html_entity_decode($result['filename'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
			$sort_order[$key] = $value['filename'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}