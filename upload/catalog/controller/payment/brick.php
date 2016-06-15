<?php

class ControllerPaymentBrick extends Controller
{
    public function index()
    {
        $this->language->load('payment/brick');
        $this->load->model('payment/brick');

        $this->model_payment_brick->initBrickConfig();
        $data['text_credit_card'] = $this->language->get('text_credit_card');
        $data['text_start_date'] = $this->language->get('text_start_date');
        $data['text_wait'] = $this->language->get('text_wait');
        $data['text_loading'] = $this->language->get('text_loading');

        $data['entry_cc_number'] = $this->language->get('entry_cc_number');
        $data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
        $data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');
        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['public_key'] = Paymentwall_Config::getInstance()->getPublicKey();

        $data['months'] = array();
        for ($i = 1; $i <= 12; $i++) {
            $data['months'][] = array(
                'text' => sprintf('%02d', $i),
                'value' => sprintf('%02d', $i)
            );
        }

        $today = getdate();
        $data['year_expire'] = array();
        for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
            $data['year_expire'][] = array(
                'text' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
                'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
            );
        }

        return $this->load->view('payment/brick.tpl', $data);
    }

    /**
     * Validate Brick request
     */
    public function validate()
    {
        $this->load->model('checkout/order');
        $this->load->model('payment/brick');
        $this->load->model('account/activity');
        $this->load->model('setting/setting');
        $this->language->load('payment/brick');

        $defaultConfigs = $this->model_setting_setting->getSetting('config');
        $data = array(
            'status' => 'error',
            'message' => '',
            'redirect' => false
        );

        if (!isset($this->session->data['order_id']) || !isset($this->request->post['cc_brick_token']) || !isset($this->request->post['cc_brick_token'])) {
            $data['message'] = "Oops, Something went wrong. Please try again!";
        } elseif ($orderInfo = $this->model_checkout_order->getOrder($this->session->data['order_id'])) {

            if ($this->customer->isLogged()) {
                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'name' => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
                    'order_id' => $this->session->data['order_id']
                );

                $this->model_account_activity->addActivity('order_account', $activity_data);
            } else {
                $activity_data = array(
                    'name' => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
                    'order_id' => $this->session->data['order_id']
                );
                $this->model_account_activity->addActivity('order_guest', $activity_data);
            }

            $this->model_payment_brick->initBrickConfig();

            $charge = new Paymentwall_Charge();
            $charge->create(array_merge(
                $this->prepareCardInfo($orderInfo),
                $this->getUserProfileData($orderInfo)
            ));
            $response = $charge->getPublicData();

            if ($charge->isSuccessful()) {
                if ($charge->isCaptured()) {
                    $this->model_checkout_order->addOrderHistory(
                        $this->session->data['order_id'],
                        $this->config->get('brick_complete_status'),
                        'The order approved, Transaction ID: #' . $charge->getId(),
                        true
                    );
                    $data['message'] = $this->language->get('text_order_processed');
                } elseif ($charge->isUnderReview()) {
                    $this->model_checkout_order->addOrderHistory(
                        $this->session->data['order_id'],
                        $this->config->get('brick_under_review_status'),
                        'The order is under review!',
                        true
                    );
                    $data['message'] = $this->language->get('text_order_under_review');
                }

                $data['status'] = 'success';
                $data['redirect'] = $this->url->link('checkout/success');
            } else {
                $response = json_decode($response, true);
                $data['message'] = $response['error']['message'];
            }

        } else {
            $data['message'] =  $this->language->get('text_order_invalid');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data));
    }

    private function getUserProfileData($orderInfo)
    {
        return array(
            'customer[city]' => $orderInfo['payment_city'],
            'customer[state]' => $orderInfo['payment_zone'],
            'customer[address]' => $orderInfo['payment_address_1'],
            'customer[country]' => $orderInfo['payment_iso_code_2'],
            'customer[zip]' => $orderInfo['payment_postcode'],
            'customer[username]' => $orderInfo['customer_id'] ? $orderInfo['customer_id'] : $_SERVER['REMOTE_ADDR'],
            'customer[firstname]' => $orderInfo['payment_firstname'],
            'customer[lastname]' => $orderInfo['payment_lastname'],
            'email' => $orderInfo['email'],
        );
    }

    private function prepareCardInfo($orderInfo)
    {
        $post = $this->request->post;
        return array(
            'email' => $orderInfo['email'],
            'amount' => number_format($orderInfo['total'], 2, '.', ''),
            'currency' => $orderInfo['currency_code'],
            'token' => $post['cc_brick_token'],
            'fingerprint' => $post['cc_brick_fingerprint'],
            'description' => 'Order #' . $orderInfo['order_id']
        );
    }
}
