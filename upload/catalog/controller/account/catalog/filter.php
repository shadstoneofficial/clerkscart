<?php
class ControllerAccountCatalogFilter extends Controller {
	private $error = array();
  
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('account/catalog/filter');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$filters = $this->model_account_catalog_filter->getFilters($filter_data);

			foreach ($filters as $filter) {
				$json[] = array(
					'filter_id' => $filter['filter_id'],
					'name'      => strip_tags(html_entity_decode($filter['group'] . ' &gt; ' . $filter['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}