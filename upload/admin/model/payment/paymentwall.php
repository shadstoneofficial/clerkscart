<?php

class ModelPaymentPaymentwall extends Model
{
    public function getAllStatuses()
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status");
        foreach ($query->rows as $value) {
            $result[$value['order_status_id']] = $value['name'];
        }
        return $result;
    }
}