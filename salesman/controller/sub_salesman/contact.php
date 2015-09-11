<?php
class ControllerSubSalesmanContact extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('sub_salesman/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_phone'] = $this->language->get('text_phone');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_title'] = $this->language->get('text_title');
		$data['text_content'] = $this->language->get('text_content');
		$data['text_contact_list'] = $this->language->get('text_contact_list');
		$data['text_contact_content'] = $this->language->get('text_contact_content');
		$data['text_reply_flg_0'] = $this->language->get('text_reply_flg_0');
		$data['text_reply_flg_1'] = $this->language->get('text_reply_flg_1');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['entry_captcha'] = $this->language->get('entry_captcha');
		$data['entry_date_contacted_fr'] = $this->language->get('entry_date_contacted_fr');
		$data['entry_date_contacted_to'] = $this->language->get('entry_date_contacted_to');
		$data['entry_date_replied_fr'] = $this->language->get('entry_date_replied_fr');
		$data['entry_date_replied_to'] = $this->language->get('entry_date_replied_to');
		$data['entry_reply_flg'] = $this->language->get('entry_reply_flg');


		$data['column_num'] = $this->language->get('column_num');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_contact_title'] = $this->language->get('column_contact_title');
		$data['column_reply_flg'] = $this->language->get('column_reply_flg');
		$data['column_contact_content'] = $this->language->get('column_contact_content');
		$data['column_reply_content'] = $this->language->get('column_reply_content');
		$data['column_date_contacted'] = $this->language->get('column_date_contacted');
		$data['column_date_replied'] = $this->language->get('column_date_replied');

		$data['button_submit'] = $this->language->get('button_submit');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_edit'] = $this->language->get('button_edit');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['contact_title'])) {
			$data['contact_title'] = $this->request->post['contact_title'];
		} else {
			$data['contact_title'] = '';
		}

		if (isset($this->request->post['contact_email'])) {
			$data['contact_email'] = $this->request->post['contact_email'];
		} else {
			$data['contact_email'] = '';
		}

		if (isset($this->request->post['contact_phone'])) {
			$data['contact_phone'] = $this->request->post['contact_phone'];
		} else {
			$data['contact_phone'] = '';
		}

		if (isset($this->request->post['contact_content'])) {
			$data['contact_content'] = $this->request->post['contact_content'];
		} else {
			$data['contact_content'] = '';
		}

		if (isset($this->request->post['captcha'])) {
			$data['captcha'] = $this->request->post['captcha'];
		} else {
			$data['captcha'] = '';
		}

		if (isset($this->request->get['filter_contact_title'])) {
			$data['filter_contact_title'] = $this->request->get['filter_contact_title'];
		} else {
			$data['filter_contact_title'] = '';
		}

		if (isset($this->request->get['filter_reply_flg'])) {
			$data['filter_reply_flg'] = $this->request->get['filter_reply_flg'];
		} else {
			$data['filter_reply_flg'] = null;
		}

		if (isset($this->request->get['filter_date_replied_fr'])) {
			$data['filter_date_replied_fr'] = $this->request->get['filter_date_replied_fr'];
		} else {
			$data['filter_date_replied_fr'] = null;
		}

		if (isset($this->request->get['filter_date_replied_to'])) {
			$data['filter_date_replied_to'] = $this->request->get['filter_date_replied_to'];
		} else {
			$data['filter_date_replied_to'] = null;
		}

		if (isset($this->request->get['filter_date_contacted_fr'])) {
			$data['filter_date_contacted_fr'] = $this->request->get['filter_date_contacted_fr'];
		} else {
			$data['filter_date_contacted_fr'] = null;
		}

		if (isset($this->request->get['filter_date_contacted_to'])) {
			$data['filter_date_contacted_to'] = $this->request->get['filter_date_contacted_to'];
		} else {
			$data['filter_date_contacted_to'] = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'contact_title';
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

		$filter_data = array(
				'filter_contact_title'               => $data['filter_contact_title'],
				'filter_reply_flg'                   => $data['filter_reply_flg'],
				'filter_date_replied_fr'             => $data['filter_date_replied_fr'],
				'filter_date_replied_to'             => $data['filter_date_replied_to'],
				'filter_date_contacted_fr'           => $data['filter_date_contacted_fr'],
				'filter_date_contacted_to'           => $data['filter_date_contacted_to'],
				'sort'                               => $sort,
				'order'                              => $order,
				'start'                              => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit'                              => $this->config->get('config_limit_admin')
		);

		if (isset($this->error['contact_title'])) {
			$data['error_contact_title'] = $this->error['contact_title'];
		} else {
			$data['error_contact_title'] = '';
		}

		if (isset($this->error['contact_email'])) {
			$data['error_contact_email'] = $this->error['contact_email'];
		} else {
			$data['error_contact_email'] = '';
		}

		if (isset($this->error['contact_phone'])) {
			$data['error_contact_phone'] = $this->error['contact_phone'];
		} else {
			$data['error_contact_phone'] = '';
		}

		if (isset($this->error['contact_content'])) {
			$data['error_contact_content'] = $this->error['contact_content'];
		} else {
			$data['error_contact_content'] = '';
		}

		if (isset($this->error['captcha'])) {
			$data['error_captcha'] = $this->error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}

		$data['action'] = $this->url->link('sub_salesman/contact');

		$this->load->model('tool/image');

		if ($this->config->get('config_image')) {
			$data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get('config_image_location_width'), $this->config->get('config_image_location_height'));
		} else {
			$data['image'] = false;
		}

		$url = '';

		if (isset($this->request->get['filter_contact_title'])) {
			$url .= '&filter_contact_title=' . urlencode(html_entity_decode($this->request->get['filter_contact_title'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_reply_flg'])) {
			$url .= '&filter_reply_flg=' . urlencode(html_entity_decode($this->request->get['filter_reply_flg'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_replied_fr'])) {
			$url .= '&filter_date_replied_fr=' . $this->request->get['filter_date_replied_fr'];
		}

		if (isset($this->request->get['filter_date_replied_to'])) {
			$url .= '&filter_date_replied_to=' . $this->request->get['filter_date_replied_to'];
		}

		if (isset($this->request->get['filter_date_contacted_fr'])) {
			$url .= '&filter_date_contacted_fr=' . $this->request->get['filter_date_contacted_fr'];
		}

		if (isset($this->request->get['filter_date_contacted_to'])) {
			$url .= '&filter_date_contacted_to=' . $this->request->get['filter_date_contacted_to'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_contact_title'] = $this->url->link('sub_salesman/contact', 'token=' . $this->session->data['token'] . '&sort=contact_title' . $url, 'SSL');
		$data['sort_reply_flg'] = $this->url->link('sub_salesman/contact', 'token=' . $this->session->data['token'] . '&sort=reply_flg' . $url, 'SSL');
		$data['sort_date_contacted'] = $this->url->link('sub_salesman/contact', 'token=' . $this->session->data['token'] . '&sort=date_contacted' . $url, 'SSL');
		$data['sort_date_replied'] = $this->url->link('sub_salesman/contact', 'token=' . $this->session->data['token'] . '&sort=date_replied' . $url, 'SSL');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('sub_salesman/contact', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$this->load->model('sub_salesman/contact');

		$contacts_total = $this->model_sub_salesman_contact->getTotalContacts($filter_data);

		$contacts = $this->model_sub_salesman_contact->getContacts($filter_data);

		foreach ($contacts as $key=>$contact) {

			$data['contacts'][] = array(
					'contact_id'           => $contact['contact_id'],
					'contact_title'        => $contact['contact_title'],
					'num'                  => $key+1,
					'reply_flg'            => $contact['reply_flg'],
					'contact_content'      => $contact['contact_content'],
					'reply_content'        => $contact['reply_content'],
					'date_contacted'       => date($this->language->get('date_format_short'), strtotime($contact['date_contacted'])),
					'date_replied'         => (!is_null($contact['date_replied'])? (date($this->language->get('date_format_short'), strtotime($contact['date_replied']))) : null),
					'edit'                 => $this->url->link('sub_salesman/contact/getForm', 'token=' . $this->session->data['token'] . '&contact_id=' . $contact['contact_id'] . $url, 'SSL')
			);
		}

		$url = '';

		if (isset($this->request->get['filter_contact_title'])) {
			$url .= '&filter_contact_title=' . urlencode(html_entity_decode($this->request->get['filter_contact_title'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_reply_flg'])) {
			$url .= '&filter_reply_flg=' . urlencode(html_entity_decode($this->request->get['filter_reply_flg'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_replied_fr'])) {
			$url .= '&filter_date_replied_fr=' . $this->request->get['filter_date_replied_fr'];
		}

		if (isset($this->request->get['filter_date_replied_to'])) {
			$url .= '&filter_date_replied_to=' . $this->request->get['filter_date_replied_to'];
		}

		if (isset($this->request->get['filter_date_contacted_fr'])) {
			$url .= '&filter_date_contacted_fr=' . $this->request->get['filter_date_contacted_fr'];
		}

		if (isset($this->request->get['filter_date_contacted_to'])) {
			$url .= '&filter_date_contacted_to=' . $this->request->get['filter_date_contacted_to'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $contacts_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sub_salesman/contact', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($contacts_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($contacts_total - $this->config->get('config_limit_admin'))) ? $contacts_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $contacts_total, ceil($contacts_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['token'] = $this->session->data['token'];

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		$this->response->setOutput($this->load->view('sub_salesman/contact_list.tpl', $data));
	}

	public function getForm() {
		$this->load->language('sub_salesman/contact');

		$this->load->model('sub_salesman/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_phone'] = $this->language->get('text_phone');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_title'] = $this->language->get('text_title');
		$data['text_content'] = $this->language->get('text_content');
		$data['text_reply'] = $this->language->get('text_reply');
		$data['text_contact_content'] = $this->language->get('text_contact_content');
		$data['text_reply_content'] = $this->language->get('text_reply_content');
		$data['text_title_reply'] = $this->language->get('text_title_reply');

		$data ['button_save'] = $this->language->get ( 'button_save' );
		$data ['button_cancel'] = $this->language->get ( 'button_cancel' );


		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$contact_id = $this->request->get['contact_id'];

		$contact_info = $this->model_sub_salesman_contact->getContact($contact_id);

		if (!empty($contact_info)) {
			$data['contact_title'] = $contact_info['contact_title'];
		} else {
			$data['contact_title'] = '';
		}

		if (!empty($contact_info)) {
			$data['contact_email'] = $contact_info['contact_email'];
		} else {
			$data['contact_email'] = '';
		}

		if (!empty($contact_info)) {
			$data['contact_phone'] = $contact_info['contact_phone'];
		} else {
			$data['contact_phone'] = '';
		}

		if (!empty($contact_info)) {
			$data['contact_content'] =$contact_info['contact_content'];
		} else {
			$data['contact_content'] = '';
		}

		if (isset($this->request->post['reply_content'])) {
			$data['reply_content'] = $this->request->post['reply_content'];
		} elseif (!empty($contact_info)) {
			$data['reply_content'] = $contact_info['reply_content'];
		} else {
			$data['reply_content'] = '';
		}

		if (isset($this->error['reply_content'])) {
			$data['error_reply_content'] = $this->error['reply_content'];
		} else {
			$data['error_reply_content'] = '';
		}


		$url ='';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('sub_salesman/contact', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);


		$data['cancel'] = $this->url->link('sub_salesman/contact', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['action'] = $this->url->link('sub_salesman/contact/edit', 'token=' . $this->session->data['token'] . '&contact_id=' . $this->request->get['contact_id'] . $url, 'SSL');

		$data['token'] = $this->session->data['token'];
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('sub_salesman/contact_form.tpl', $data));
	}

	public function edit() {
		$this->load->language('sub_salesman/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sub_salesman/contact');

		$salesman_id = $this->salesman->getId ();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			unset($this->session->data['captcha']);

			$this->model_sub_salesman_contact->editContact($this->request->get['contact_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('sub_salesman/contact', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	protected function validate() {

		if ((utf8_strlen($this->request->post['reply_content']) < 10) || (utf8_strlen($this->request->post['reply_content']) > 250)) {
			$this->error['reply_content'] = $this->language->get('error_reply_content');
		}

		return !$this->error;
	}
}
