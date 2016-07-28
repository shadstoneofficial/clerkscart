<?php
class ControllerModuleAccount extends Controller {
	public function index() {
		$this->load->language('module/account');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_forgotten'] = $this->language->get('text_forgotten');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_address'] = $this->language->get('text_address');
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

		$data['logged'] = $this->customer->isLogged();
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
    $data['forgotten'] = $this->url->link('account/forgotten', '', true);
    if (!$this->customer->isLogged()) {
    $data['logout'] = $this->url->link('account/logout', '', true);
		$data['account'] = $this->url->link('account/account', '', true);
		$data['edit'] = $this->url->link('account/edit', '', true);
		$data['password'] = $this->url->link('account/password', '', true);
		$data['address'] = $this->url->link('account/address', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['reward'] = $this->url->link('account/reward', '', true);
		$data['return'] = $this->url->link('account/return', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);
		$data['recurring'] = $this->url->link('account/recurring', '', true);
    } else {
		$data['logout'] = $this->url->link('account/logout', 'token=' . $this->session->data['token'], true);
		$data['account'] = $this->url->link('account/account', 'token=' . $this->session->data['token'], true);
		$data['edit'] = $this->url->link('account/edit', 'token=' . $this->session->data['token'], true);
		$data['password'] = $this->url->link('account/password', 'token=' . $this->session->data['token'], true);
		$data['address'] = $this->url->link('account/address', 'token=' . $this->session->data['token'], true);
		$data['wishlist'] = $this->url->link('account/wishlist', 'token=' . $this->session->data['token'], true);
		$data['order'] = $this->url->link('account/order', 'token=' . $this->session->data['token'], true);
		$data['download'] = $this->url->link('account/download', 'token=' . $this->session->data['token'], true);
		$data['reward'] = $this->url->link('account/reward', 'token=' . $this->session->data['token'], true);
		$data['return'] = $this->url->link('account/return', 'token=' . $this->session->data['token'], true);
		$data['transaction'] = $this->url->link('account/transaction', 'token=' . $this->session->data['token'], true);
		$data['newsletter'] = $this->url->link('account/newsletter', 'token=' . $this->session->data['token'], true);
		$data['recurring'] = $this->url->link('account/recurring', 'token=' . $this->session->data['token'], true);
    $seller_id = $this->customer->getId();
    $data['seller'] = $this->customer->hasSellerPermission($seller_id);
    $url = '';
    $data['seller_edit'] = $this->url->link('account/catalog/seller/edit', 'token=' . $this->session->data['token'], true);
    $data['product_form'] = $this->url->link('account/catalog/product',  'token=' . $this->session->data['token'] . $url, true);
    $data['product_add'] = $this->url->link('account/catalog/product/add',  'token=' . $this->session->data['token'] . $url, true);
    $data['download_form'] = $this->url->link('account/catalog/download',  'token=' . $this->session->data['token'] . $url, true);
    $data['download_add'] = $this->url->link('account/catalog/download/add',  'token=' . $this->session->data['token'] . $url, true);
    $data['orderlist'] = $this->url->link('account/sale/order', 'token=' . $this->session->data['token'], true);
    $data['seller_transaction'] = $this->url->link('account/catalog/transaction', 'token=' . $this->session->data['token'], true);
    $data['seller_shipping'] = $this->url->link('account/catalog/shipping', 'token=' . $this->session->data['token'], true);
    $data['returnlist'] = $this->url->link('account/sale/return', 'token=' . $this->session->data['token'], true);
    $data['seller_coupon'] = $this->url->link('account/catalog/coupon', 'token=' . $this->session->data['token'], true);
    }
		return $this->load->view('module/account', $data);
	}
}
