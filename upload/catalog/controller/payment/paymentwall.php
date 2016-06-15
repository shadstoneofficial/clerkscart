<?php

class ControllerPaymentPaymentwall extends Controller
{
    public function index()
    {
        $this->language->load('payment/paymentwall');

        $data['pay_via_paymentwall'] = $this->language->get('pay_via_paymentwall');
        $data['widget_link'] = $this->url->link('payment/paymentwall/widget', '', 'SSL');

        return $this->load->view('payment/paymentwall.tpl', $data);
    }

    public function widget()
    {
        $this->load->model('checkout/order');
        $this->load->model('payment/paymentwall');
        $this->language->load('payment/paymentwall');
        $orderInfo = array();

        if (isset($this->session->data['order_id'])) {

            $orderInfo = $this->model_checkout_order->getOrder($this->session->data['order_id']);

            $seller_id = $orderInfo['seller_id'];

            $this->cart->clear($seller_id);
            // Add to activity log
            $this->load->model('account/activity');

            if ($this->customer->isLogged()) {
                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
                    'order_id'    => $this->session->data['order_id']
                );

                $this->model_account_activity->addActivity('order_account', $activity_data);
            } else {
                $activity_data = array(
                    'name'     => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
                    'order_id' => $this->session->data['order_id']
                );

                $this->model_account_activity->addActivity('order_guest', $activity_data);
            }

            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['guest']);
            unset($this->session->data['comment']);
            unset($this->session->data['order_id']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);
            unset($this->session->data['totals']);
        } else {
            // Redirect to shopping cart
            $this->response->redirect($this->url->link('common/home'));
        }

        $this->document->setTitle($this->language->get('widget_title'));

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('widget_title'),
            'separator' => $this->language->get('text_separator')
        );

        $data['widget_title'] = $this->language->get('widget_title');
        $data['widget_notice'] = $this->language->get('widget_notice');
        $data['iframe'] = $this->generateWidget($orderInfo);

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('payment/paymentwall_widget.tpl', $data));
    }

    private function generateWidget($orderInfo)
    {
        $this->load->model('payment/paymentwall');
        // Init Paymentwall configs
        $this->model_payment_paymentwall->initPaymentwallConfig();

        $widget = new Paymentwall_Widget(
            $this->customer->getId() ? $this->customer->getId() : $_SERVER["REMOTE_ADDR"],
            $this->config->get('paymentwall_widget'),
            array(
                new Paymentwall_Product(
                    $orderInfo['order_id'],
                    $orderInfo['currency_value'] > 0 ? $orderInfo['total'] * $orderInfo['currency_value'] : $orderInfo['total'], // when currency_value <= 0 changes to 1
                    $orderInfo['currency_code'],
                    'Order #' . $orderInfo['order_id']
                )
            ),
            array_merge(
                array(
                    'success_url' => $this->config->get('paymentwall_success_url'),
                    'email' => $orderInfo['email'],
                    'integration_module' => 'opencart',
                    'test_mode' => $this->config->get('paymentwall_test')
                ),
                $this->getUserProfileData($orderInfo)
            ));

        return $widget->getHtmlCode(array(
            'width' => '100%',
            'height' => 400,
            'frameborder' => 0
        ));
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
}
