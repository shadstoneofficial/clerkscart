<?php
class ModelShippingFlat extends Model {
	function getQuote($address, $seller_id) {
		$this->load->language('shipping/flat');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->customer->getSellersetting('flat_geo_zone_id', $seller_id) . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (!$this->customer->getSellersetting('flat_geo_zone_id', $seller_id)) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$quote_data = array();

			$quote_data['flat'] = array(
				'code'         => 'flat.flat',
				'title'        => $this->language->get('text_description'),
				'cost'         => $this->customer->getSellersetting('flat_cost', $seller_id),
				'tax_class_id' => $this->customer->getSellersetting('flat_tax_class_id', $seller_id),
				'text'         => $this->currency->format($this->tax->calculate($this->customer->getSellersetting('flat_cost', $seller_id), $this->customer->getSellersetting('flat_tax_class_id', $seller_id), $this->config->get('config_tax')), $this->session->data['currency'])
			);

			$method_data = array(
				'code'       => 'flat',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->customer->getSellersetting('flat_sort_order', $seller_id),
				'error'      => false
			);
		}

		return $method_data;
	}
}