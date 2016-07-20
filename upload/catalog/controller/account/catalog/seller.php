<?php
class ControllerAccountCatalogSeller extends Controller {
	private $error = array();
  
   	public function edit() {
    $seller_id = $this->customer->getId();
    if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/catalog/seller', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		} else if ($this->customer->hasSellerPermission($seller_id) == 0) {
			$this->session->data['redirect'] = $this->url->link('account/catalog/seller', 'token=' . $this->session->data['token'], true);

			$this->response->redirect($this->url->link('account/account', 'token=' . $this->session->data['token'], true));
		}
    
		$this->load->language('account/catalog/seller');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/catalog/seller');
    $seller_id = $this->customer->getId();
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_account_catalog_seller->editSeller($seller_id, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			$this->response->redirect($this->url->link('account/account', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}
  
  	protected function getForm() {
    $seller_id = $this->customer->getId();
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['seller_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_seller_detail'] = $this->language->get('text_seller_detail');
		$data['text_seller_address'] = $this->language->get('text_seller_address');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_cheque'] = $this->language->get('text_cheque');
		$data['text_paypal'] = $this->language->get('text_paypal');
		$data['text_bank'] = $this->language->get('text_bank');

		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
    $data['entry_logo'] = $this->language->get('entry_logo');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_website'] = $this->language->get('entry_website');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_tax'] = $this->language->get('entry_tax');
		$data['entry_payment'] = $this->language->get('entry_payment');
		$data['entry_cheque'] = $this->language->get('entry_cheque');
		$data['entry_paypal'] = $this->language->get('entry_paypal');
		$data['entry_bank_name'] = $this->language->get('entry_bank_name');
		$data['entry_bank_branch_number'] = $this->language->get('entry_bank_branch_number');
		$data['entry_bank_swift_code'] = $this->language->get('entry_bank_swift_code');
		$data['entry_bank_account_name'] = $this->language->get('entry_bank_account_name');
		$data['entry_bank_account_number'] = $this->language->get('entry_bank_account_number');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_description'] = $this->language->get('entry_description');

		$data['help_code'] = $this->language->get('help_code');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
    $data['button_image_add'] = $this->language->get('button_image_add');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_payment'] = $this->language->get('tab_payment');
		$data['tab_transaction'] = $this->language->get('tab_transaction');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}
                
                if (isset($this->error['sellerdescription'])) {
			$data['error_sellerdescription'] = $this->error['sellerdescription'];
		} else {
			$data['error_sellerdescription'] = '';
		}
                
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['cheque'])) {
			$data['error_cheque'] = $this->error['cheque'];
		} else {
			$data['error_cheque'] = '';
		}

		if (isset($this->error['paypal'])) {
			$data['error_paypal'] = $this->error['paypal'];
		} else {
			$data['error_paypal'] = '';
		}

		if (isset($this->error['bank_account_name'])) {
			$data['error_bank_account_name'] = $this->error['bank_account_name'];
		} else {
			$data['error_bank_account_name'] = '';
		}

		if (isset($this->error['bank_account_number'])) {
			$data['error_bank_account_number'] = $this->error['bank_account_number'];
		} else {
			$data['error_bank_account_number'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['address_1'])) {
			$data['error_address_1'] = $this->error['address_1'];
		} else {
			$data['error_address_1'] = '';
		}

		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}

		if (isset($this->error['postcode'])) {
			$data['error_postcode'] = $this->error['postcode'];
		} else {
			$data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$data['error_zone'] = $this->error['zone'];
		} else {
			$data['error_zone'] = '';
		}

		$url = '';
    
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('account/account', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/catalog/seller/edit', 'token=' . $this->session->data['token'] . '&seller_id=' . $seller_id . $url, true)
		);

		$data['action'] = $this->url->link('account/catalog/seller/edit', 'token=' . $this->session->data['token'] . '&seller_id=' . $seller_id . $url, true);

		$data['cancel'] = $this->url->link('account/account', 'token=' . $this->session->data['token'] . $url, true);
     
		$seller_info = $this->model_account_catalog_seller->getSeller($seller_id);

		$data['token'] = $this->session->data['token'];

		if (isset($seller_id)) {
			$data['seller_id'] = $seller_id;
		} else {
			$data['seller_id'] = 0;
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($seller_info)) {
			$data['firstname'] = $seller_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($seller_info)) {
			$data['lastname'] = $seller_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

    // Logo
		if (isset($this->request->post['logo'])) {
			$data['logo'] = $this->request->post['logo'];
		} elseif (!empty($seller_info)) {
			$data['logo'] = $seller_info['logo'];
		} else {
			$data['logo'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['logo']) && is_file(DIR_IMAGE . $this->request->post['logo'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['logo'], 100, 100);
		} elseif (!empty($seller_info) && is_file(DIR_IMAGE . $seller_info['logo'])) {
			$data['thumb'] = $this->model_tool_image->resize($seller_info['logo'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
                
                if (isset($this->request->post['sellerdescription'])) {
			$data['sellerdescription'] = $this->request->post['sellerdescription'];
		} elseif (!empty($seller_info)) {
			$data['sellerdescription'] = $seller_info['sellerdescription'];
		} else {
			$data['sellerdescription'] = '';
		}
                
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($seller_info)) {
			$data['email'] = $seller_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($seller_info)) {
			$data['status'] = $seller_info['status'];
		} else {
			$data['status'] = true;
		}
		
		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($seller_info)) {
			$data['telephone'] = $seller_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['fax'])) {
			$data['fax'] = $this->request->post['fax'];
		} elseif (!empty($seller_info)) {
			$data['fax'] = $seller_info['fax'];
		} else {
			$data['fax'] = '';
		}

		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} elseif (!empty($seller_info)) {
			$data['company'] = $seller_info['company'];
		} else {
			$data['company'] = '';
		}

		if (isset($this->request->post['website'])) {
			$data['website'] = $this->request->post['website'];
		} elseif (!empty($seller_info)) {
			$data['website'] = $seller_info['website'];
		} else {
			$data['website'] = '';
		}

		if (isset($this->request->post['address_1'])) {
			$data['address_1'] = $this->request->post['address_1'];
		} elseif (!empty($seller_info)) {
			$data['address_1'] = $seller_info['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
			$data['address_2'] = $this->request->post['address_2'];
		} elseif (!empty($seller_info)) {
			$data['address_2'] = $seller_info['address_2'];
		} else {
			$data['address_2'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($seller_info)) {
			$data['city'] = $seller_info['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (!empty($seller_info)) {
			$data['postcode'] = $seller_info['postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = $this->request->post['country_id'];
		} elseif (!empty($seller_info)) {
			$data['country_id'] = $seller_info['country_id'];
		} else {
			$data['country_id'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = $this->request->post['zone_id'];
		} elseif (!empty($seller_info)) {
			$data['zone_id'] = $seller_info['zone_id'];
		} else {
			$data['zone_id'] = '';
		}

		if (isset($this->request->post['tax'])) {
			$data['tax'] = $this->request->post['tax'];
		} elseif (!empty($seller_info)) {
			$data['tax'] = $seller_info['tax'];
		} else {
			$data['tax'] = '';
		}

		if (isset($this->request->post['payment'])) {
			$data['payment'] = $this->request->post['payment'];
		} elseif (!empty($seller_info)) {
			$data['payment'] = $seller_info['payment'];
		} else {
			$data['payment'] = 'cheque';
		}

		if (isset($this->request->post['cheque'])) {
			$data['cheque'] = $this->request->post['cheque'];
		} elseif (!empty($seller_info)) {
			$data['cheque'] = $seller_info['cheque'];
		} else {
			$data['cheque'] = '';
		}

		if (isset($this->request->post['paypal'])) {
			$data['paypal'] = $this->request->post['paypal'];
		} elseif (!empty($seller_info)) {
			$data['paypal'] = $seller_info['paypal'];
		} else {
			$data['paypal'] = '';
		}

		if (isset($this->request->post['bank_name'])) {
			$data['bank_name'] = $this->request->post['bank_name'];
		} elseif (!empty($seller_info)) {
			$data['bank_name'] = $seller_info['bank_name'];
		} else {
			$data['bank_name'] = '';
		}

		if (isset($this->request->post['bank_branch_number'])) {
			$data['bank_branch_number'] = $this->request->post['bank_branch_number'];
		} elseif (!empty($seller_info)) {
			$data['bank_branch_number'] = $seller_info['bank_branch_number'];
		} else {
			$data['bank_branch_number'] = '';
		}

		if (isset($this->request->post['bank_swift_code'])) {
			$data['bank_swift_code'] = $this->request->post['bank_swift_code'];
		} elseif (!empty($seller_info)) {
			$data['bank_swift_code'] = $seller_info['bank_swift_code'];
		} else {
			$data['bank_swift_code'] = '';
		}

		if (isset($this->request->post['bank_account_name'])) {
			$data['bank_account_name'] = $this->request->post['bank_account_name'];
		} elseif (!empty($seller_info)) {
			$data['bank_account_name'] = $seller_info['bank_account_name'];
		} else {
			$data['bank_account_name'] = '';
		}

		if (isset($this->request->post['bank_account_number'])) {
			$data['bank_account_number'] = $this->request->post['bank_account_number'];
		} elseif (!empty($seller_info)) {
			$data['bank_account_number'] = $seller_info['bank_account_number'];
		} else {
			$data['bank_account_number'] = '';
		}


		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/catalog/seller_form', $data));
	}

  protected function validateForm() {
  $seller_id = $this->customer->getId();
		/*if (!$this->user->hasPermission('modify', 'marketing/affiliate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}*/

		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}
                
                if (utf8_strlen(trim($this->request->post['sellerdescription'])) > 500) {
			$this->error['sellerdescription'] = $this->language->get('error_sellerdescription');
		}
                
		if ((utf8_strlen($this->request->post['email']) > 96) || (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL))) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ($this->request->post['payment'] == 'cheque') {
			if ($this->request->post['cheque'] == '') {
				$this->error['cheque'] = $this->language->get('error_cheque');
			}
		} elseif ($this->request->post['payment'] == 'paypal') {
			if ((utf8_strlen($this->request->post['paypal']) > 96) || !filter_var($this->request->post['paypal'], FILTER_VALIDATE_EMAIL)) {
				$this->error['paypal'] = $this->language->get('error_paypal');
			}
		} elseif ($this->request->post['payment'] == 'bank') {
			if ($this->request->post['bank_account_name'] == '') {
				$this->error['bank_account_name'] = $this->language->get('error_bank_account_name');
			}

			if ($this->request->post['bank_account_number'] == '') {
				$this->error['bank_account_number'] = $this->language->get('error_bank_account_number');
			}
		}

		$seller_info = $this->model_account_catalog_seller->getSellerByEmail($this->request->post['email']);

		if (!isset($seller_id)) {
			if ($seller_info) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		} else {
			if ($seller_info && ($seller_id != $seller_info['seller_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}

		if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

		if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
			$this->error['postcode'] = $this->language->get('error_postcode');
		}

		if ($this->request->post['country_id'] == '') {
			$this->error['country'] = $this->language->get('error_country');
		}

		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
			$this->error['zone'] = $this->language->get('error_zone');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	public function transaction() {
		$this->load->language('account/catalog/seller');

		$this->load->model('account/catalog/seller');

    $seller_id = $this->customer->getId();

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_balance'] = $this->language->get('text_balance');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_description'] = $this->language->get('column_description');
		$data['column_amount'] = $this->language->get('column_amount');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['transactions'] = array();

		$results = $this->model_account_catalog_seller->getTransactions($seller_id, ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['transactions'][] = array(
				'amount'      => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'description' => $result['description'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$data['balance'] = $this->currency->format($this->model_account_catalog_seller->getTransactionTotal($seller_id), $this->config->get('config_currency'));

		$transaction_total = $this->model_account_catalog_seller->getTotalTransactions($seller_id);

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('account/catalog/transaction', 'token=' . $this->session->data['token'] . '&seller_id=' . $seller_id . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($transaction_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($transaction_total - 10)) ? $transaction_total : ((($page - 1) * 10) + 10), $transaction_total, ceil($transaction_total / 10));

		$this->response->setOutput($this->load->view('account/catalog/seller_transaction', $data));
	}
}
