<?php
class ModelExtensionExtension extends Model {
	function getExtensions($type) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "'");

		return $query->rows;
	}
  
  public function getInstalled($type) {
		$extension_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "' ORDER BY code");

		foreach ($query->rows as $result) {
			$extension_data[] = $result['code'];
		}

		return $extension_data;
	}
}