<?php
class ControllerAccountAccount extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		} 

    $data['token'] = $this->session->data['token'];

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_my_account'] = $this->language->get('text_my_account');
		$data['text_my_orders'] = $this->language->get('text_my_orders');
		$data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_credit_card'] = $this->language->get('text_credit_card');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_reward'] = $this->language->get('text_reward');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_sellershipping'] = $this->language->get('text_sellershipping');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_recurring'] = $this->language->get('text_recurring');  
    $data['text_clerkad'] = $this->language->get('text_clerkad');
    $data['text_selleredit'] = $this->language->get('text_selleredit');
    $data['text_productlist'] = $this->language->get('text_productlist');
    $data['text_product_add'] = $this->language->get('text_product_add');
    $data['text_downloadlist'] = $this->language->get('text_downloadlist');
    $data['text_download_add'] = $this->language->get('text_download_add');
    $data['text_orderlist'] = $this->language->get('text_orderlist');
    $data['text_coupon'] = $this->language->get('text_coupon');
    $url = '';
    $seller_id = $this->customer->getId();
    $data['seller'] = $this->customer->hasSellerPermission($seller_id);
    $data['seller_edit'] = $this->url->link('account/catalog/seller/edit', 'token=' . $this->session->data['token'] . $url, true);
    $data['product_form'] = $this->url->link('account/catalog/product',  'token=' . $this->session->data['token'] . $url, true);
    $data['product_add'] = $this->url->link('account/catalog/product/add',  'token=' . $this->session->data['token'] . $url, true);
    $data['download_form'] = $this->url->link('account/catalog/download',  'token=' . $this->session->data['token'] . $url, true);
    $data['download_add'] = $this->url->link('account/catalog/download/add',  'token=' . $this->session->data['token'] . $url, true);
    $data['orderlist'] = $this->url->link('account/sale/order', 'token=' . $this->session->data['token'], true);
    $data['seller_transaction'] = $this->url->link('account/catalog/transaction', 'token=' . $this->session->data['token'], true);
    $data['seller_shipping'] = $this->url->link('account/catalog/shipping', 'token=' . $this->session->data['token'], true);
    $data['returnlist'] = $this->url->link('account/sale/return', 'token=' . $this->session->data['token'], true);
    $data['seller_coupon'] = $this->url->link('account/catalog/coupon', 'token=' . $this->session->data['token'], true);


		$data['edit'] = $this->url->link('account/edit', 'token=' . $this->session->data['token'], true);
		$data['password'] = $this->url->link('account/password', 'token=' . $this->session->data['token'], true);
		$data['address'] = $this->url->link('account/address', 'token=' . $this->session->data['token'], true);
		
		$data['credit_cards'] = array();
		
		$files = glob(DIR_APPLICATION . 'controller/credit_card/*.php');
		
		foreach ($files as $file) {
			$code = basename($file, '.php');
			
			if ($this->config->get($code . '_status') && $this->config->get($code)) {
				$this->load->language('credit_card/' . $code);

				$data['credit_cards'][] = array(
					'name' => $this->language->get('heading_title'),
					'href' => $this->url->link('credit_card/' . $code, '', true)
				);
			}
		}
		
		$data['wishlist'] = $this->url->link('account/wishlist', 'token=' . $this->session->data['token'], true);
		$data['order'] = $this->url->link('account/order', 'token=' . $this->session->data['token'], true);
		$data['download'] = $this->url->link('account/download', 'token=' . $this->session->data['token'], true);
    
    $data['download'] = $this->url->link('account/download', 'token=' . $this->session->data['token'], true);
		
		if ($this->config->get('reward_status')) {
			$data['reward'] = $this->url->link('account/reward', 'token=' . $this->session->data['token'], true);
		} else {
			$data['reward'] = '';
		}		
		
		$data['return'] = $this->url->link('account/return', 'token=' . $this->session->data['token'], true);
		$data['transaction'] = $this->url->link('account/transaction', 'token=' . $this->session->data['token'], true);
		$data['newsletter'] = $this->url->link('account/newsletter', 'token=' . $this->session->data['token'], true);
		$data['recurring'] = $this->url->link('account/recurring', 'token=' . $this->session->data['token'], true);
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		$this->response->setOutput($this->load->view('account/account', $data));
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
