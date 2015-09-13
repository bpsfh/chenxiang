<?php
class ControllerSalesmanUser extends Controller {
	private $error = array ();
	public function index() {
		$this->load->language ( 'salesman/user' );

		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );

		$this->load->model ( 'salesman/user' );

		$this->edit ();
	}
	protected function validateForm() {
		if ((utf8_strlen ( trim ( $this->request->post ['fullname'] ) ) < 2) || (utf8_strlen ( trim ( $this->request->post ['fullname'] ) ) > 32)) {
			$this->error ['fullname'] = $this->language->get ( 'error_fullname' );
		}

		if ($this->request->post ['password'] || (! isset ( $this->request->get ['user_id'] ))) {
			if ((utf8_strlen ( $this->request->post ['password'] ) < 4) || (utf8_strlen ( $this->request->post ['password'] ) > 20)) {
				$this->error ['password'] = $this->language->get ( 'error_password' );
			}

			if ($this->request->post ['password'] != $this->request->post ['confirm']) {
				$this->error ['confirm'] = $this->language->get ( 'error_confirm' );
			}
		}

		if ((utf8_strlen ( $this->request->post ['telephone'] ) < 3) || (utf8_strlen ( $this->request->post ['telephone'] ) > 32)) {
			$this->error ['telephone'] = $this->language->get ( 'error_telephone' );
		}

		if ((utf8_strlen ( trim ( $this->request->post ['address'] ) ) < 3) || (utf8_strlen ( trim ( $this->request->post ['address'] ) ) > 128)) {
			$this->error ['address'] = $this->language->get ( 'error_address' );
		}

		if ((utf8_strlen ( trim ( $this->request->post ['city'] ) ) < 2) || (utf8_strlen ( trim ( $this->request->post ['city'] ) ) > 128)) {
			$this->error ['city'] = $this->language->get ( 'error_city' );
		}

		$this->load->model ( 'localisation/country' );

		$country_info = $this->model_localisation_country->getCountry ( $this->request->post ['country_id'] );

		if ($country_info && $country_info ['postcode_required'] && (utf8_strlen ( trim ( $this->request->post ['postcode'] ) ) < 2 || utf8_strlen ( trim ( $this->request->post ['postcode'] ) ) > 10)) {
			$this->error ['postcode'] = $this->language->get ( 'error_postcode' );
		}

		if ($this->request->post ['country_id'] == '') {
			$this->error ['country'] = $this->language->get ( 'error_country' );
		}

		if (! isset ( $this->request->post ['zone_id'] ) || $this->request->post ['zone_id'] == '') {
			$this->error ['zone'] = $this->language->get ( 'error_zone' );
		}

		if (!isset($this->request->post['filename']) || $this->request->post['filename']  == '') {
			$this->error['identity_img'] = $this->language->get('error_identity_img');
		}
		
		// Add sangsanghu 2015/09/11 ST
		if (!isset($this->request->post['sub_commission_def_percent']) || !$this->request->post['sub_commission_def_percent']) {
			$this->error['sub_commission_def_percent'] = $this->language->get('error_commission_def_percent');
		} else {
			if ((!preg_match('/^[0-9]*[1-9][0-9]*$/', $this->request->post['sub_commission_def_percent']))
					|| ($this->request->post['sub_commission_def_percent'] > $this->model_salesman_user->getParentCommission())) {
						$this->error['sub_commission_def_percent'] = sprintf($this->language->get('error_commission_def_percent0'), $this->model_salesman_user->getParentCommission() . "%");
			}
		}
		
		if (!$this->request->post['sub_settle_suspend_days']) {
			$this->error['sub_settle_suspend_days'] = $this->language->get('error_settle_suspend_days');
		} else {
			if (!preg_match('/^[0-9]*[1-9][0-9]*$/', $this->request->post['sub_settle_suspend_days'])) {
				$this->error['sub_settle_suspend_days'] = $this->language->get('error_settle_suspend_days0');
			}
		}
		// Add sangsanghu 2015/09/11 END
		
		return ! $this->error;
	}
	public function edit() {
		if (! $this->salesman->isLogged ()) {
			return new Action ( 'common/login' );
		}

		$this->load->language ( 'salesman/user' );

		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );

		$this->load->model ( 'salesman/user' );

		$this->load->model ( 'salesman/address' );

		if (($this->request->server ['REQUEST_METHOD'] == 'POST') && $this->validateForm ()) {

			$this->model_salesman_user->editSalesman ( $this->request->post );

			$this->model_salesman_address->editAddress ( $this->salesman->getAddressId (), $this->request->post );

			$this->session->data ['success'] = $this->language->get ( 'text_success' );

			$url = '';

			if (isset ( $this->request->get ['sort'] )) {
				$url .= '&sort=' . $this->request->get ['sort'];
			}

			if (isset ( $this->request->get ['order'] )) {
				$url .= '&order=' . $this->request->get ['order'];
			}

			if (isset ( $this->request->get ['page'] )) {
				$url .= '&page=' . $this->request->get ['page'];
			}

			$this->response->redirect ( $this->url->link ( 'salesman/user/edit', 'token=' . $this->session->data ['token'] . $url, 'SSL' ) );
		}

		$this->getSalesmanForm ();
	}
	public function getSalesmanForm() {
		if (! $this->salesman->isLogged ()) {
			return new Action ( 'common/login' );
		}

		$salesman_id = $this->salesman->getId ();
		$this->load->model ( 'salesman/user' );
		$user_info = $this->model_salesman_user->getSalesman ( $salesman_id );

		$address_id = $user_info ['address_id'];
		$this->load->model ( 'salesman/address' );
		$address_info = $this->model_salesman_address->getAddress ( $address_id );

		$data ['heading_title'] = $this->language->get ( 'heading_title' );

		$data ['text_form'] = $this->language->get ( 'text_edit' );
		$data ['text_enabled'] = $this->language->get ( 'text_enabled' );
		$data ['text_disabled'] = $this->language->get ( 'text_disabled' );

		$data ['entry_username'] = $this->language->get ( 'entry_username' );
		$data ['entry_user_group'] = $this->language->get ( 'entry_user_group' );
		$data ['entry_password'] = $this->language->get ( 'entry_password' );
		$data ['entry_confirm'] = $this->language->get ( 'entry_confirm' );
		$data ['entry_fullname'] = $this->language->get ( 'entry_fullname' );
		$data ['entry_email'] = $this->language->get ( 'entry_email' );
		$data ['entry_image'] = $this->language->get ( 'entry_image' );
		$data ['entry_status'] = $this->language->get ( 'entry_status' );

		$data ['text_yes'] = $this->language->get ( 'text_yes' );
		$data ['text_no'] = $this->language->get ( 'text_no' );
		$data ['text_select'] = $this->language->get ( 'text_select' );
		$data ['text_none'] = $this->language->get ( 'text_none' );
		$data ['text_loading'] = $this->language->get ( 'text_loading' );

		$data ['entry_address'] = $this->language->get ( 'entry_address' );
		$data ['entry_postcode'] = $this->language->get ( 'entry_postcode' );
		$data ['entry_city'] = $this->language->get ( 'entry_city' );
		$data ['entry_country'] = $this->language->get ( 'entry_country' );
		$data ['entry_zone'] = $this->language->get ( 'entry_zone' );
		$data ['entry_default'] = $this->language->get ( 'entry_default' );
		$data ['entry_telephone'] = $this->language->get ( 'entry_telephone' );
		$data ['entry_fax'] = $this->language->get ( 'entry_fax' );
		$data ['entry_identity'] = $this->language->get('entry_identity');
		$data ['entry_identity_img'] = $this->language->get('entry_identity_img');
		
		$data ['entry_commission_def_percent'] = $this->language->get('entry_commission_def_percent');
		$data ['entry_settle_suspend_days'] = $this->language->get('entry_settle_suspend_days');

		$data ['button_save'] = $this->language->get ( 'button_save' );
		$data ['button_cancel'] = $this->language->get ( 'button_cancel' );
		$data ['button_upload'] = $this->language->get('button_upload');
		$data ['button_download'] = $this->language->get('button_download');

		if (isset ( $this->error ['fullname'] )) {
			$data ['error_fullname'] = $this->error ['fullname'];
		} else {
			$data ['error_fullname'] = '';
		}

		if (isset ( $this->error ['warning'] )) {
			$data ['error_warning'] = $this->error ['warning'];
		} else {
			$data ['error_warning'] = '';
		}

		if (isset ( $this->session->data ['success'] )) {
			$data ['success'] = $this->session->data ['success'];

			unset ( $this->session->data ['success'] );
		} else {
			$data ['success'] = '';
		}

		if (isset ( $this->error ['password'] )) {
			$data ['error_password'] = $this->error ['password'];
		} else {
			$data ['error_password'] = '';
		}

		if (isset ( $this->error ['confirm'] )) {
			$data ['error_confirm'] = $this->error ['confirm'];
		} else {
			$data ['error_confirm'] = '';
		}

		if (isset ( $this->error ['telephone'] )) {
			$data ['error_telephone'] = $this->error ['telephone'];
		} else {
			$data ['error_telephone'] = '';
		}

		if (isset ( $this->error ['address'] )) {
			$data ['error_address'] = $this->error ['address'];
		} else {
			$data ['error_address'] = '';
		}

		if (isset ( $this->error ['city'] )) {
			$data ['error_city'] = $this->error ['city'];
		} else {
			$data ['error_city'] = '';
		}

		if (isset ( $this->error ['postcode'] )) {
			$data ['error_postcode'] = $this->error ['postcode'];
		} else {
			$data ['error_postcode'] = '';
		}

		if (isset ( $this->error ['country'] )) {
			$data ['error_country'] = $this->error ['country'];
		} else {
			$data ['error_country'] = '';
		}

		if (isset ( $this->error ['zone'] )) {
			$data ['error_zone'] = $this->error ['zone'];
		} else {
			$data ['error_zone'] = '';
		}

		if (isset($this->error['identity_img'])) {
			$data['error_identity_img'] = $this->error['identity_img'];
		} else {
			$data['error_identity_img'] = '';
		}
		
		// Add sangsanghu 2015/09/11 ST
		if (isset($this->error['sub_commission_def_percent'])) {
			$data['error_sub_commission_def_percent'] = $this->error['sub_commission_def_percent'];
		} else {
			$data['error_sub_commission_def_percent'] = '';
		}
		
		if (isset($this->error['sub_settle_suspend_days'])) {
			$data['error_sub_settle_suspend_days'] = $this->error['sub_settle_suspend_days'];
		} else {
			$data['error_sub_settle_suspend_days'] = '';
		}
		
		// Add sangsanghu 2015/09/11 END

		$url = '';

		if (isset ( $this->request->get ['sort'] )) {
			$url .= '&sort=' . $this->request->get ['sort'];
		}

		if (isset ( $this->request->get ['order'] )) {
			$url .= '&order=' . $this->request->get ['order'];
		}

		if (isset ( $this->request->get ['page'] )) {
			$url .= '&page=' . $this->request->get ['page'];
		}

		$data ['breadcrumbs'] = array ();

		$data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'text_home' ),
				'href' => $this->url->link ( 'common/dashboard', 'token=' . $this->session->data ['token'], 'SSL' )
		);

		$data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'heading_title' ),
				'href' => $this->url->link ( 'salesman/user/edit', 'token=' . $this->session->data ['token'] . $url, 'SSL' )
		);
		$data ['action'] = $this->url->link ( 'salesman/user/edit', 'token=' . $this->session->data ['token'] . '&user_id=' . $salesman_id . $url, 'SSL' );

		$data ['cancel'] = $this->url->link ( 'salesman/common/dashboard', 'token=' . $this->session->data ['token'] . $url, 'SSL' );

		/*
		 * if (!empty($user_info)) {
		 * $data['salesman_group_id'] = $user_info['salesman_group_id'];
		 * } else {
		 * $data['salesman_group_id'] = '';
		 * }
		 *
		 * $this->load->model('salesman/user_group');
		 * $data['user_groups'] = $this->model_salesman_user_group->getUserGroups();
		 */

		$data ['confirm'] = '';
		$data ['password'] = '';

		if (isset ( $this->request->post ['fullname'] )) {
			$data ['fullname'] = $this->request->post ['fullname'];
		} elseif (! empty ( $user_info )) {
			$data ['fullname'] = $user_info ['fullname'];
		} else {
			$data ['fullname'] = '';
		}

		if (isset ( $this->request->post ['email'] )) {
			$data ['email'] = $this->request->post ['email'];
		} elseif (! empty ( $user_info )) {
			$data ['email'] = $user_info ['email'];
		} else {
			$data ['email'] = '';
		}

		if (isset ( $this->request->post ['image'] )) {
			$data ['image'] = $this->request->post ['image'];
		} elseif (! empty ( $user_info )) {
			$data ['image'] = $user_info ['image'];
		} else {
			$data ['image'] = '';
		}

		$this->load->model ( 'tool/image' );

		if (isset ( $this->request->post ['image'] ) && is_file ( DIR_IMAGE . $this->request->post ['image'] )) {
			$data ['thumb'] = $this->model_tool_image->resize ( $this->request->post ['image'], 100, 100 );
		} elseif (! empty ( $user_info ) && $user_info ['image'] && is_file ( DIR_IMAGE . $user_info ['image'] )) {
			$data ['thumb'] = $this->model_tool_image->resize ( $user_info ['image'], 100, 100 );
		} else {
			$data ['thumb'] = $this->model_tool_image->resize ( 'no_image.png', 100, 100 );
		}
		$data ['placeholder'] = $this->model_tool_image->resize ( 'no_image.png', 100, 100 );

		/*
		 * if (isset($this->request->post['status'])) {
		 * $data['status'] = $this->request->post['status'];
		 * } elseif (!empty($user_info)) {
		 * $data['status'] = $user_info['status'];
		 * } else {
		 * $data['status'] = 0;
		 * }
		 */

		if (isset ( $this->request->post ['telephone'] )) {
			$data ['telephone'] = $this->request->post ['telephone'];
		} elseif (! empty ( $user_info )) {
			$data ['telephone'] = $user_info ['telephone'];
		} else {
			$data ['telephone'] = 0;
		}

		if (isset ( $this->request->post ['fax'] )) {
			$data ['fax'] = $this->request->post ['fax'];
		} elseif (! empty ( $user_info )) {
			$data ['fax'] = $user_info ['fax'];
		} else {
			$data ['fax'] = '';
		}
		
		// Add sangsanghu 2015/09/11 ST
		// 下级业务员佣金默认百分比
		if (isset($this->request->post['sub_settle_suspend_days'])) {
			$data['sub_settle_suspend_days'] = $this->request->post['sub_settle_suspend_days'];
		} elseif (!empty($user_info)) {
			$data['sub_settle_suspend_days'] = $user_info['sub_settle_suspend_days'];
		} else {
			$data['sub_settle_suspend_days'] = '';
		}
		
		// 下级业务员佣金申请滞后期
		if (isset($this->request->post['sub_commission_def_percent'])) {
			$data['sub_commission_def_percent'] = $this->request->post['sub_commission_def_percent'];
		} elseif (!empty($user_info)) {
			$data['sub_commission_def_percent'] = $user_info['sub_commission_def_percent'];
		} else {
			$data['sub_commission_def_percent'] = '';
		}
		// Add sangsanghu 2015/09/11 END

		if (isset ( $this->request->post ['address'] )) {
			$data ['address'] = $this->request->post ['address'];
		} elseif (! empty ( $address_info )) {
			$data ['address'] = $address_info ['address'];
		} else {
			$data ['address'] = '';
		}

		if (isset ( $this->request->post ['postcode'] )) {
			$data ['postcode'] = $this->request->post ['postcode'];
		} elseif (! empty ( $address_info )) {
			$data ['postcode'] = $address_info ['postcode'];
		} else {
			$data ['postcode'] = '';
		}

		if (isset ( $this->request->post ['city'] )) {
			$data ['city'] = $this->request->post ['city'];
		} elseif (! empty ( $address_info )) {
			$data ['city'] = $address_info ['city'];
		} else {
			$data ['city'] = '';
		}

		if (isset ( $this->request->post ['country_id'] )) {
			$data ['country_id'] = $this->request->post ['country_id'];
		} elseif (! empty ( $address_info )) {
			$data ['country_id'] = $address_info ['country_id'];
		} else {
			$data ['country_id'] = $this->config->get ( 'config_country_id' );
		}

		if (isset ( $this->request->post ['zone_id'] )) {
			$data ['zone_id'] = $this->request->post ['zone_id'];
		} elseif (! empty ( $address_info )) {
			$data ['zone_id'] = $address_info ['zone_id'];
		} else {
			$data ['zone_id'] = '';
		}

		$this->load->model ( 'salesman/upload' );
		$user_identity_img_info = $this->model_salesman_upload->getSalesmanImgUpload ( $salesman_id, '1' );

		if (isset($this->request->post['upload_id'])) {
			$data ['upload_id'] = $this->request->post['upload_id'];
		} elseif (! empty ( $user_identity_img_info )) {
			$data ['upload_id'] = $user_identity_img_info ['upload_id'];
		} else {
			$data ['upload_id'] = 0;
		}

		if (isset($this->request->post['salesman_upload_description'])) {
			$data['salesman_upload_description'] = $this->request->post['salesman_upload_description'];
		} elseif (! empty ( $user_identity_img_info )) {
			$data ['salesman_upload_description'] = $this->model_salesman_upload->getUploadDescriptions($user_identity_img_info['upload_id']);
		} else {
			$data['salesman_upload_description'] = array();
		}

		if (isset($this->request->post['filename'])) {
			$data['filename'] = $this->request->post['filename'];
		} elseif (! empty ( $user_identity_img_info )) {
			$data ['filename'] = $user_identity_img_info ['filename'];
		} else {
			$data['filename'] = '';
		}

		if (isset($this->request->post['mask'])) {
			$data['mask'] = $this->request->post['mask'];
		} elseif (! empty ( $user_identity_img_info )) {
			$data ['mask'] = $user_identity_img_info ['mask'];
		} else {
			$data['mask'] = '';
		}

		if (isset($this->request->post['category'])) {
			$data['category'] = $this->request->post['category'];
		} elseif (! empty ( $user_identity_img_info )) {
			$data ['category'] = $user_identity_img_info ['category'];
		} else {
			$data['category'] = 1;
		}

		$data['download'] = $this->url->link('salesman/upload/download', 'token=' . $this->session->data['token'] . '&mask=' . $data['mask'] . $url, 'SSL');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model ( 'localisation/country' );

		$data ['countries'] = $this->model_localisation_country->getCountries ();

		$data ['header'] = $this->load->controller ( 'common/header' );
		$data ['column_left'] = $this->load->controller ( 'common/column_left' );
		$data ['footer'] = $this->load->controller ( 'common/footer' );

		$data ['token'] = $this->session->data ['token'];
		$this->response->setOutput ( $this->load->view ( 'salesman/user_form.tpl', $data ) );
	}

	public function country() {
		$json = array ();

		$this->load->model ( 'localisation/country' );

		$country_info = $this->model_localisation_country->getCountry ( $this->request->get ['country_id'] );

		if ($country_info) {
			$this->load->model ( 'localisation/zone' );

			$json = array (
					'country_id' => $country_info ['country_id'],
					'name' => $country_info ['name'],
					'iso_code_2' => $country_info ['iso_code_2'],
					'iso_code_3' => $country_info ['iso_code_3'],
					'address_format' => $country_info ['address_format'],
					'postcode_required' => $country_info ['postcode_required'],
					'zone' => $this->model_localisation_zone->getZonesByCountryId ( $this->request->get ['country_id'] ),
					'status' => $country_info ['status']
			);
		}
		$this->response->addHeader ( 'Content-Type: application/json' );
		$this->response->setOutput ( json_encode ( $json ) );
	}
}