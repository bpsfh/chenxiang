<?php
class ControllerCommonLogout extends Controller {
	public function index() {
		$this->salesman->logout();

		unset($this->session->data['token']);

		$this->response->redirect($this->url->link('common/login', '', 'SSL'));
	}
}