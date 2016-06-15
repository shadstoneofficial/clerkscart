<?php

class ControllerPaymentBrick extends Controller
{
    private $error = array();

    // Generate default configs
    public function install() {
        $this->load->model('setting/setting');
        $defaultConfigs = $this->model_setting_setting->getSetting('config');
        $this->model_setting_setting->editSetting('brick', array(
            'brick_under_review_status' => 1, // Pending
            'brick_complete_status' => $defaultConfigs['config_complete_status_id'],
            'brick_test_mode' => 0,
            'brick_status' => 1, // Pending
        ));
    }

    public function uninstall(){
        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting('brick');
    }

    /**
     * Index action
     */
    public function index()
    {
        $this->load->model('setting/setting');
        $this->load->model('payment/brick');
        $this->load->language('payment/brick');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('brick', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->document->setTitle($this->language->get('heading_title'));
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_authorization'] = $this->language->get('text_authorization');
        $data['text_sale'] = $this->language->get('text_sale');

        $data['entry_public_key'] = $this->language->get('entry_public_key');
        $data['entry_private_key'] = $this->language->get('entry_private_key');
        $data['entry_public_test_key'] = $this->language->get('entry_public_test_key');
        $data['entry_private_test_key'] = $this->language->get('entry_private_test_key');
        $data['entry_complete_status'] = $this->language->get('entry_complete_status');
        $data['entry_under_review_status'] = $this->language->get('entry_under_review_status');
        $data['entry_test'] = $this->language->get('entry_test');

        $data['entry_transaction'] = $this->language->get('entry_transaction');
        $data['entry_total'] = $this->language->get('entry_total');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_active'] = $this->language->get('entry_active');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['statuses'] = $this->model_payment_brick->getAllStatuses();
        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

        $data['breadcrumbs'] = array(
            array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => false
            ),
            array(
                'text' => $this->language->get('text_payment'),
                'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
            ),
            array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('payment/brick', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
            )
        );

        $data['action'] = $this->url->link('payment/brick', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        $data['brick_public_key'] = $this->checkPostRequestIsset(
            'brick_public_key',
            $this->config->get('brick_public_key'));

        $data['brick_private_key'] = $this->checkPostRequestIsset(
            'brick_private_key',
            $this->config->get('brick_private_key'));

        $data['brick_public_test_key'] = $this->checkPostRequestIsset(
            'brick_public_test_key',
            $this->config->get('brick_public_test_key'));

        $data['brick_private_test_key'] = $this->checkPostRequestIsset(
            'brick_private_test_key',
            $this->config->get('brick_private_test_key'));

        $data['brick_complete_status'] = $this->checkPostRequestIsset(
            'brick_complete_status',
            $this->config->get('brick_complete_status'));

        $data['brick_under_review_status'] = $this->checkPostRequestIsset(
            'brick_under_review_status',
            $this->config->get('brick_under_review_status'));

        $data['brick_test_mode'] = $this->checkPostRequestIsset(
            'brick_test_mode',
            $this->config->get('brick_test_mode'));

        $data['brick_status'] = $this->checkPostRequestIsset(
            'brick_status',
            $this->config->get('brick_status'));

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/brick.tpl', $data));
    }

    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    private function checkPostRequestIsset($key, $default)
    {
        return isset($this->request->post[$key]) ? $this->request->post[$key] : $default;
    }

    /**
     * Validator
     * @return bool
     */
    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'payment/brick')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return empty($this->error);
    }
}
