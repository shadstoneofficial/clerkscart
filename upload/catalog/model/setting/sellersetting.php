<?php
class ModelSettingSellersetting extends Model {
	public function getSellersetting($code, $store_id = 0, $seller_id) {
		$data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seller_setting WHERE store_id = '" . (int)$store_id . "' AND seller_id = '" . (int)$seller_id . "' AND `code` = '" . $this->db->escape($code) . "'");

		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = json_decode($result['value'], true);
			}
		}

		return $data;
	}
}