<?php
class ModelCheckoutSeller extends Model {
  public function getSeller($seller_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "seller WHERE seller_id = '" . (int)$seller_id . "'");

		return $query->row;
	}  
}