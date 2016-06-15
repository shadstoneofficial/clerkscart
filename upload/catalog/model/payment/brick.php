<?php
if (!class_exists('Paymentwall_Config'))
    require_once DIR_SYSTEM . '/thirdparty/paymentwall-php/lib/paymentwall.php';

class ModelPaymentBrick extends Model
{
    public function getMethod($address, $total)
    {
        $this->load->language('payment/brick');
        $method_data = array();
        if ($this->config->get('brick_status') && $total > 0) {
            $method_data = array(
                'code' => 'brick',
                'title' => $this->language->get('text_title'),
                'sort_order' => $this->config->get('brick_sort_order'),
                'terms' => ''
            );
        }

        return $method_data;
    }

    public function initBrickConfig()
    {
        Paymentwall_Config::getInstance()->set(array(
            'api_type' => Paymentwall_Config::API_GOODS,
            'public_key' => $this->config->get('brick_test_mode') ? $this->config->get('brick_public_test_key') : $this->config->get('brick_public_key'),
            'private_key' => $this->config->get('brick_test_mode') ? $this->config->get('brick_private_test_key') : $this->config->get('brick_private_key')
        ));
    }
}