<?php
class ControllerSellerSellerGroup extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('seller/seller_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('seller/seller_group');

		$this->getList();
	}

	public function add() {
		$this->load->language('seller/seller_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('seller/seller_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_seller_seller_group->addSellerGroup($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('seller/seller_group', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('seller/seller_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('seller/seller_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_seller_seller_group->editSellerGroup($this->request->get['seller_group_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('seller/seller_group', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('seller/seller_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('seller/seller_group');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $seller_group_id) {
				$this->model_seller_seller_group->deleteSellerGroup($seller_group_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('seller/seller_group', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cgd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('seller/seller_group', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('seller/seller_group/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('seller/seller_group/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['seller_groups'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$seller_group_total = $this->model_seller_seller_group->getTotalSellerGroups();

		$results = $this->model_seller_seller_group->getSellerGroups($filter_data);

		foreach ($results as $result) {
			$data['seller_groups'][] = array(
				'seller_group_id' => $result['seller_group_id'],
				'name'              => $result['name'] . (($result['seller_group_id'] == $this->config->get('config_seller_group_id')) ? $this->language->get('text_default') : null),
				'sort_order'        => $result['sort_order'],
				'edit'              => $this->url->link('seller/seller_group/edit', 'token=' . $this->session->data['token'] . '&seller_group_id=' . $result['seller_group_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('seller/seller_group', 'token=' . $this->session->data['token'] . '&sort=cgd.name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('seller/seller_group', 'token=' . $this->session->data['token'] . '&sort=cg.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $seller_group_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('seller/seller_group', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($seller_group_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($seller_group_total - $this->config->get('config_limit_admin'))) ? $seller_group_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $seller_group_total, ceil($seller_group_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('seller/seller_group_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['seller_group_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_approval'] = $this->language->get('entry_approval');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
    $data['entry_prodlimit'] = $this->language->get('entry_prodlimit');
    $data['entry_imglimit'] = $this->language->get('entry_imglimit');
    $data['entry_downloadlimit'] = $this->language->get('entry_downloadlimit');

		$data['help_approval'] = $this->language->get('help_approval');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('seller/seller_group', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['seller_group_id'])) {
			$data['action'] = $this->url->link('seller/seller_group/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('seller/seller_group/edit', 'token=' . $this->session->data['token'] . '&seller_group_id=' . $this->request->get['seller_group_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('seller/seller_group', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['seller_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$seller_group_info = $this->model_seller_seller_group->getSellerGroup($this->request->get['seller_group_id']);
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['seller_group_description'])) {
			$data['seller_group_description'] = $this->request->post['seller_group_description'];
		} elseif (isset($this->request->get['seller_group_id'])) {
			$data['seller_group_description'] = $this->model_seller_seller_group->getSellerGroupDescriptions($this->request->get['seller_group_id']);
		} else {
			$data['seller_group_description'] = array();
		}

		if (isset($this->request->post['approval'])) {
			$data['approval'] = $this->request->post['approval'];
		} elseif (!empty($seller_group_info)) {
			$data['approval'] = $seller_group_info['approval'];
		} else {
			$data['approval'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($seller_group_info)) {
			$data['sort_order'] = $seller_group_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

                if (isset($this->request->post['prodlimit'])) {
			$data['prodlimit'] = $this->request->post['prodlimit'];
		} elseif (!empty($seller_group_info)) {
			$data['prodlimit'] = $seller_group_info['prodlimit'];
		} else {
			$data['prodlimit'] = '';
		}
    
                if (isset($this->request->post['imglimit'])) {
			$data['imglimit'] = $this->request->post['imglimit'];
		} elseif (!empty($seller_group_info)) {
			$data['imglimit'] = $seller_group_info['imglimit'];
		} else {
			$data['imglimit'] = '';
		}
    
                if (isset($this->request->post['downloadlimit'])) {
			$data['downloadlimit'] = $this->request->post['downloadlimit'];
		} elseif (!empty($seller_group_info)) {
			$data['downloadlimit'] = $seller_group_info['downloadlimit'];
		} else {
			$data['downloadlimit'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('seller/seller_group_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'seller/seller_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['seller_group_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 32)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'seller/seller_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('setting/store');
		$this->load->model('seller/seller');

		foreach ($this->request->post['selected'] as $seller_group_id) {
			if ($this->config->get('config_seller_group_id') == $seller_group_id) {
				$this->error['warning'] = $this->language->get('error_default');
			}

			$store_total = $this->model_setting_store->getTotalStoresBySellerGroupId($seller_group_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			}

			$seller_total = $this->model_seller_seller->getTotalSellersBySellerGroupId($seller_group_id);

			if ($seller_total) {
				$this->error['warning'] = sprintf($this->language->get('error_seller'), $seller_total);
			}
		}

		return !$this->error;
	}
}
