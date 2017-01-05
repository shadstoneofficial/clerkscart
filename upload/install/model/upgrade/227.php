<?php
class ModelUpgrade227 extends Model {
	public function upgrade() {
	//Voucher
    	$query = $this->db->query("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_PREFIX . "voucher' AND COLUMN_NAME = 'seller_id'");
          if (!$query->num_rows) {
	$this->db->query("ALTER TABLE `" . DB_PREFIX . "voucher` ADD COLUMN `seller_id` int(11) NOT NULL AFTER `voucher_id`");
          }		
  }
}
