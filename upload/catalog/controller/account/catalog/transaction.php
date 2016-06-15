<?php
class ControllerAccountCatalogTransaction extends Controller {
public function index() {
    $seller_id = $this->customer->getId();
    if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/catalog/transaction', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		} else if ($this->customer->hasSellerPermission($seller_id) == 0) {
			$this->session->data['redirect'] = $this->url->link('account/catalog/transaction', 'token=' . $this->session->data['token'], true);

			$this->response->redirect($this->url->link('account/account', 'token=' . $this->session->data['token'], true));
		}

		$this->load->language('account/catalog/seller');

		$this->load->model('account/catalog/seller');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}
  protected function getList() {
  $seller_id = $this->customer->getId();
    if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/catalog/transaction', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		} else if ($this->customer->hasSellerPermission($seller_id) == 0) {
			$this->session->data['redirect'] = $this->url->link('account/catalog/transaction', 'token=' . $this->session->data['token'], true);

			$this->response->redirect($this->url->link('account/account', 'token=' . $this->session->data['token'], true));
		}
  if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
    
  $url = '';
    
  if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('account/account', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/catalog/transaction', 'token=' . $this->session->data['token'] . $url, true)
		);
    
    $seller_id = $this->customer->getId();

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_balance'] = $this->language->get('text_balance');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_description'] = $this->language->get('column_description');
		$data['column_amount'] = $this->language->get('column_amount');

		$data['transactions'] = array();

		$results = $this->model_account_catalog_seller->getTransactions($seller_id, ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['transactions'][] = array(
				'amount'      => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'description' => $result['description'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$data['balance'] = $this->currency->format($this->model_account_catalog_seller->getTransactionTotal($seller_id), $this->config->get('config_currency'));

		$transaction_total = $this->model_account_catalog_seller->getTotalTransactions($seller_id);

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('account/catalog/transaction', 'token=' . $this->session->data['token'] . '&seller_id=' . $seller_id . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($transaction_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($transaction_total - 10)) ? $transaction_total : ((($page - 1) * 10) + 10), $transaction_total, ceil($transaction_total / 10));

    $data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/catalog/sellertransaction', $data));
  }
}