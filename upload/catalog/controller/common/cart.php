<?php
class ControllerCommonCart extends Controller {
	public function index() {
		$this->load->language('common/cart');
                unset($this->session->data['shipping_method']);
		unset($this->session->data['shipping_methods']);
		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_recurring'] = $this->language->get('text_recurring');
		$data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($this->cart->getTotal(), $this->session->data['currency']));
		$data['text_loading'] = $this->language->get('text_loading');
                $data['seller_name'] = $this->language->get('seller_name');
                $data['shopping_cart'] = $this->url->link('checkout/cart');

		$data['button_remove'] = $this->language->get('button_remove');

		$this->load->model('tool/image');
		$this->load->model('tool/upload');
   
    if ($this->cart->hasProducts()) {
      $data['products'] = $this->cart->hasProducts();
      } else {
       $data['products'] = false;
      }

   $vouchers = array();

      if (!empty($this->session->data['vouchers'])) {
	 foreach ($this->session->data['vouchers'] as $voucher) {
	     $vouchers[] = array(
            'seller_id'   => $voucher['seller_id']
		);
	     } 
	}
   
   $seller_carts = $this->cart->getSellercarts();

   $carts_merge = array_merge($seller_carts, $vouchers);
    
   foreach ($carts_merge as $key => $seller) {
     $carts_merge[$key] = serialize($seller);
   } 
   
   $carts_unigue = array_unique($carts_merge);
   
   foreach ($carts_unigue as $key => $unigue) {
     $carts_unigue[$key] = unserialize($unigue);
   }  
    $carts = $carts_unigue;

      $data['carts'] = array();
      
      foreach ($carts as $cart) {

      $seller_id = $cart['seller_id'];

			if ($this->config->get('config_cart_weight')) {
				$weight = $this->weight->format($this->cart->getSellerweight($seller_id), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
			} else {
				$weight = '';
			}

			$products = array();

			$cartproducts = $this->cart->getSellerproducts($seller_id);
			foreach ($cartproducts as $product) {
				$product_total = 0;

				foreach ($cartproducts as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
				}

				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
				} else {
					$image = '';
				}

				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				// Display prices
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				// Display prices
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $this->session->data['currency']);
				} else {
					$total = false;
				}

				$recurring = '';

				if ($product['recurring']) {
					$frequencies = array(
						'day'        => $this->language->get('text_day'),
						'week'       => $this->language->get('text_week'),
						'semi_month' => $this->language->get('text_semi_month'),
						'month'      => $this->language->get('text_month'),
						'year'       => $this->language->get('text_year'),
					);

					if ($product['recurring']['trial']) {
						$recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
					}

					if ($product['recurring']['duration']) {
						$recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					} else {
						$recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					}
				}
        
        $url = '';
        
				$products[] = array(
					'cart_id'   => $product['cart_id'],
					'thumb'     => $image,
					'name'      => $product['name'],
					'model'     => $product['model'],
					'option'    => $option_data,
					'recurring' => $recurring,
					'quantity'  => $product['quantity'],
					'stock'     => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
					'reward'    => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
					'price'     => $price,
					'total'     => $total,
					'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);
			}

			 // Gift Voucher
			$vouchers = array();

			if (!empty($this->session->data['vouchers'])) {
			 foreach ($this->session->data['vouchers'] as $key => $voucher) {
                           if ($voucher['seller_id'] == $cart['seller_id']) {
					$vouchers[] = array(
						'key'         => $key,
						'description' => $voucher['description'],
                                                'seller_id'   => $voucher['seller_id'],
						'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)
					);
				} 
                           }
			}

			// Totals
			$this->load->model('extension/extension');

			$totals = array();
			$taxes = $this->cart->getSellertaxes($seller_id);
			$total = 0;
			
			// Because __call can not keep var references so we put them into an array. 			
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
        'seller_id'  => &$seller_id,
				'total'  => &$total
			);
			
			// Display prices
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);
						
						// We have to put the totals in an array so that they pass by reference.
						$this->{'model_total_' . $result['code']}->getSellertotal($total_data);
					}
				}

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $totals);
			}
      $carttotals = array();
      foreach ($totals as $total) {
				$carttotals[] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $this->session->data['currency'])
				);
			}

			$this->load->model('extension/extension');

			$modules = array();
			
			$files = glob(DIR_APPLICATION . '/controller/total/*.php');

			if ($files) {
				foreach ($files as $file) {
					$result = $this->load->controller('total/' . basename($file, '.php'));
					
					if ($result) {
						$modules[] = $result;
					}
				}
			}
      $this->load->model('account/catalog/seller');
      
      $seller_info = $this->model_account_catalog_seller->getSeller($seller_id);

      $seller_name = $seller_info['firstname'] . '&nbsp;' . $seller_info['lastname'];
      $url = '';
      $data['carts'][] = array(
          'weight'     => $weight,
          'products'   => $products,
          'seller_name' => $seller_name,
	  'carttotals'     => $carttotals,
	  'vouchers'     => $vouchers,
          'checkout'   => $this->url->link('checkout/checkout', '&seller_id=' . $seller_id . $url, true)
				);

      }

		$data['cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);

		return $this->load->view('common/cart', $data);
	}

	public function info() {
		$this->response->setOutput($this->index());
	}
}
