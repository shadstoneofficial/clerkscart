<?php
class ModelSettingSellersetting extends Model {
	public function getSellersetting($code, $store_id = 0) {
  $seller_id = 0;
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
  
  public function editSellersetting($code, $data, $store_id = 0) {
  $seller_id = 0;
		$this->db->query("DELETE FROM `" . DB_PREFIX . "seller_setting` WHERE store_id = '" . (int)$store_id . "' AND seller_id = '" . (int)$seller_id . "' AND `code` = '" . $this->db->escape($code) . "'");

		foreach ($data as $key => $value) {
			if (substr($key, 0, strlen($code)) == $code) {
				if (!is_array($value)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "seller_setting SET store_id = '" . (int)$store_id . "', seller_id = '" . (int)$seller_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "seller_setting SET store_id = '" . (int)$store_id . "', seller_id = '" . (int)$seller_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value, true)) . "', serialized = '1'");
				}
			}
		}
  }

	public function deleteSellersetting($code, $store_id = 0) {
  $seller_id = 0;
		$this->db->query("DELETE FROM " . DB_PREFIX . "seller_setting WHERE store_id = '" . (int)$store_id . "' AND seller_id = '" . (int)$seller_id . "' AND `code` = '" . $this->db->escape($code) . "'");
	}
	
	public function getSellersettingValue($key, $store_id = 0) {
  $seller_id = 0;
		$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "seller_setting WHERE store_id = '" . (int)$store_id . "' AND seller_id = '" . (int)$seller_id . "' AND `key` = '" . $this->db->escape($key) . "'");

		if ($query->num_rows) {
			return $query->row['value'];
		} else {
			return null;	
		}
	}
	
	public function editSellersettingValue($code = '', $key = '', $value = '', $store_id = 0) {
  $seller_id = 0;
		if (!is_array($value)) {
			$this->db->query("UPDATE " . DB_PREFIX . "seller_setting SET `value` = '" . $this->db->escape($value) . "', serialized = '0'  WHERE `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "' AND seller_id = '" . (int)$seller_id . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "seller_setting SET `value` = '" . $this->db->escape(json_encode($value)) . "', serialized = '1' WHERE `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "' AND seller_id = '" . (int)$seller_id . "'");
		}
	}
}