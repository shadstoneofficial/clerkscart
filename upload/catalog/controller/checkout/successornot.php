<?php

class ControllerCheckoutSuccessornot extends Controller
{
    public function index()
    {
        $this->load->model('checkout/order');
        $result = $this->model_checkout_order->getOrder($_POST['order_id']);
        if ($result['order_status_id'] == $this->config->get('paymentwall_complete_status')) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
