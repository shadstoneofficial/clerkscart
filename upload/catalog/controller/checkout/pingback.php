<?php

class ControllerCheckoutPingback extends Controller
{
    const DEFAULT_PINGBACK_RESPONSE_SUCCESS = "OK";

    public function index()
    {
        $this->load->model('checkout/order');
        $this->load->model('payment/paymentwall');
        $this->load->model('setting/setting');

        $defaultConfigs = $this->model_setting_setting->getSetting('config');

        // Init Paymentwall configs
        $this->model_payment_paymentwall->initPaymentwallConfig();

        $pingback = new Paymentwall_Pingback($_GET, $_SERVER['REMOTE_ADDR']);
        $order = $this->model_checkout_order->getOrder($pingback->getProduct()->getId());

        if (!$order) {
            die('Order invalid!');
        }

        // Confirm order if status is null
        if (!$order['order_status']) {
            $this->model_checkout_order->addOrderHistory($order['order_id'], $defaultConfigs['config_order_status_id'], '', true);
        }

        if ($pingback->validate()) {

            if ($pingback->isDeliverable()) {
                $this->model_payment_paymentwall->callDeliveryApi($order, $pingback->getReferenceId());
                $this->model_checkout_order->addOrderHistory($pingback->getProduct()->getId(), $this->config->get('paymentwall_complete_status'), '', true);
            } elseif ($pingback->isCancelable()) {
                $this->model_checkout_order->addOrderHistory($pingback->getProduct()->getId(), $this->config->get('paymentwall_cancel_status'), '', true);
            }

            echo self::DEFAULT_PINGBACK_RESPONSE_SUCCESS;
        } else {
            echo $pingback->getErrorSummary();
        }

    }

}
