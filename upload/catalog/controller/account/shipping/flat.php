<?php
class ControllerAccountShippingFlat extends Controller {
	private $error = array();

	public function index() {
  $seller_id = $this->customer->getId();
    if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/shipping/flat', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		} else if ($this->customer->hasSellerPermission($seller_id) == 0) {
			$this->session->data['redirect'] = $this->url->link('account/shipping/flat', 'token=' . $this->session->data['token'], true);

			$this->response->redirect($this->url->link('account/account', 'token=' . $this->session->data['token'], true));
		}
		$this->load->language('account/shipping/flat');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/sellersetting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_sellersetting->editSellersetting('flat', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('account/catalog/shipping', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('account/account', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('account/catalog/shipping', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/shipping/flat', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('account/shipping/flat', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('account/catalog/shipping', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->post['flat_cost'])) {
			$data['flat_cost'] = $this->request->post['flat_cost'];
		} else {
			$data['flat_cost'] = $this->customer->getSellersetting('flat_cost', $seller_id);
		}
    
		if (isset($this->request->post['flat_tax_class_id'])) {
			$data['flat_tax_class_id'] = $this->request->post['flat_tax_class_id'];
		} else {
			$data['flat_tax_class_id'] = $this->customer->getSellersetting('flat_tax_class_id', $seller_id);
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['flat_geo_zone_id'])) {
			$data['flat_geo_zone_id'] = $this->request->post['flat_geo_zone_id'];
		} else {
			$data['flat_geo_zone_id'] = $this->customer->getSellersetting('flat_geo_zone_id', $seller_id);
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['flat_status'])) {
			$data['flat_status'] = $this->request->post['flat_status'];
		} else {
			$data['flat_status'] = $this->customer->getSellersetting('flat_status', $seller_id);
		}

		if (isset($this->request->post['flat_sort_order'])) {
			$data['flat_sort_order'] = $this->request->post['flat_sort_order'];
		} else {
			$data['flat_sort_order'] = $this->customer->getSellersetting('flat_sort_order', $seller_id);
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/shipping/flat', $data));
	}

	protected function validate() {
		$seller_id = $this->customer->getId();
    if ($this->customer->hasSellerPermission($seller_id) == 0) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}