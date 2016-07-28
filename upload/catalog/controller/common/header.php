<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		// Analytics
		$this->load->model('extension/extension');

		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_sellershipping'] = $this->language->get('text_sellershipping');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');
    
    $data['text_clerkad'] = $this->language->get('text_clerkad');
    $data['text_selleredit'] = $this->language->get('text_selleredit');
    $data['text_productlist'] = $this->language->get('text_productlist');
    $data['text_product_add'] = $this->language->get('text_product_add');
    $data['text_downloadlist'] = $this->language->get('text_downloadlist');
    $data['text_download_add'] = $this->language->get('text_download_add');
    $data['text_orderlist'] = $this->language->get('text_orderlist');
    $data['text_return'] = $this->language->get('text_return');
    $data['text_coupon'] = $this->language->get('text_coupon');

		$data['home'] = $this->url->link('common/home');
    $data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');
		$data['logged'] = $this->customer->isLogged();
    if (!$this->customer->isLogged()) {
    $data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
    } else {
    $data['wishlist'] = $this->url->link('account/wishlist', 'token=' . $this->session->data['token'], true);
		$data['account'] = $this->url->link('account/account', 'token=' . $this->session->data['token'], true);
		$data['register'] = $this->url->link('account/register', 'token=' . $this->session->data['token'], true);
		$data['login'] = $this->url->link('account/login', 'token=' . $this->session->data['token'], true);
		$data['order'] = $this->url->link('account/order', 'token=' . $this->session->data['token'], true);
		$data['transaction'] = $this->url->link('account/transaction', 'token=' . $this->session->data['token'], true);
		$data['download'] = $this->url->link('account/download', 'token=' . $this->session->data['token'], true);
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
    }
		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} elseif (isset($this->request->get['information_id'])) {
				$class = '-' . $this->request->get['information_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		return $this->load->view('common/header', $data);
	}
}
