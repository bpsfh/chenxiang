<?php
class ControllerCommonProfile extends Controller {
	public function index() {
		$this->load->language('common/menu');

		$this->load->model('salesman/user');
		$this->load->model('tool/image');

		$user_info = $this->model_salesman_user->getSalesmanByEmail($this->salesman->getEmail());

		if ($user_info) {
			$data['fullname'] = $user_info['fullname'];
			$data['email'] = $user_info['email'];
//			$data['user_group'] = $user_info['user_group'] ;

			/*
			if (is_file(DIR_IMAGE . $user_info['image'])) {
				$data['image'] = $this->model_tool_image->resize($user_info['image'], 45, 45);
			} else {
				$data['image'] = $this->model_tool_image->resize('no_image.png', 45, 45);
			}
			*/
			$data['image'] = $this->model_tool_image->resize('no_image.png', 45, 45);
		} else {
			$data['email'] = '';
			$data['image'] = '';
		}

		return $this->load->view('common/profile.tpl', $data);
	}
}
