<?php
class ModelUpgrade226 extends Model {
	public function upgrade() {
		//Voucher
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "voucher` ADD COLUMN `seller_id` int(11) NOT NULL AFTER `voucher_id`");		
	}
}