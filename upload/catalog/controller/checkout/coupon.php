<?php
class ControllerCheckoutCoupon extends Controller {
	public function index() {
		if ($this->config->get('coupon_status')) {
			$this->load->language('total/coupon');

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_loading'] = $this->language->get('text_loading');

			$data['entry_coupon'] = $this->language->get('entry_coupon');
			$data['entry_voucher'] = $this->language->get('entry_voucher');

			$data['button_coupon'] = $this->language->get('button_coupon');
			$data['button_voucher'] = $this->language->get('button_voucher');
                        $data['text_loading'] = $this->language->get('text_loading');
		        $data['button_continue'] = $this->language->get('button_continue');

			if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		        } else {
			$data['error_warning'] = '';
		        }
      
                        if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}
			
			if ($this->request->server['REQUEST_METHOD'] == 'GET') {
                        if (empty($this->request->get['seller_id'])) {
                        $data['seller_id'] = 0;
                        } else {
                        $data['seller_id'] = $this->request->get['seller_id'];    
                        }
                        }
			
			if (isset($this->session->data['coupon'])) {
				$data['coupon'] = $this->session->data['coupon'];
			} else {
				$data['coupon'] = '';
			}
			
			if (isset($this->session->data['voucher'])) {
				$data['voucher'] = $this->session->data['voucher'];
			} else {
				$data['voucher'] = '';
			}

      $this->response->setOutput($this->load->view('checkout/coupon', $data));
		}
	}

	public function coupon() {
		$this->load->language('total/coupon');
    

    if (empty($this->request->get['seller_id'])) {
     $seller_id = 0;
    } else {
     $seller_id = $this->request->get['seller_id'];    
    }


		$json = array();

		$this->load->model('total/coupon');

		if (isset($this->request->post['coupon'])) {
			$coupon = $this->request->post['coupon'];
		} else {
			$coupon = '';
		}
    
    
		$coupon_info = $this->model_total_coupon->getCoupon($coupon, $seller_id);

		if (empty($this->request->post['coupon'])) {
			$json['error'] = $this->language->get('error_empty');

			unset($this->session->data['coupon']);
		} elseif ($coupon_info) {
			$this->session->data['coupon'] = $this->request->post['coupon'];

			$json['success'] = $this->language->get('text_success');

		} else {
			$json['error'] = $this->language->get('error_coupon');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
public function voucher() {
		$this->load->language('total/voucher');

    if (empty($this->request->get['seller_id'])) {
     $seller_id = 0;
    } else {
     $seller_id = $this->request->get['seller_id'];    
    }

		$json = array();

		$this->load->model('total/voucher');

		if (isset($this->request->post['voucher'])) {
			$voucher = $this->request->post['voucher'];
		} else {
			$voucher = '';
		}

		$voucher_info = $this->model_total_voucher->getVoucher($voucher, $seller_id);

		if (empty($this->request->post['voucher'])) {
			$json['error'] = $this->language->get('error_empty');
		} elseif ($voucher_info) {
			$this->session->data['voucher'] = $this->request->post['voucher'];

			$json['success'] = $this->language->get('text_success');
		} else {
			$json['error'] = $this->language->get('error_voucher');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
}
