<?php
final class Encryption {

	private $cipher = 'aes-256-ctr';
	private $digest = 'sha256';
	private $key;

	public function __construct($key) {
		$this->key = $key;
	}

	public function encrypt($value) {
		$key = openssl_digest($this->key, $this->digest, true);
		$iv_length = openssl_cipher_iv_length($this->cipher);
		$iv = openssl_random_pseudo_bytes($iv_length);
		return base64_encode($iv . openssl_encrypt($value, $this->cipher, $key, OPENSSL_RAW_DATA, $iv));
	}

	public function decrypt($value) {
		$key = openssl_digest($this->key, $this->digest, true);
		$iv_length = openssl_cipher_iv_length($this->cipher);
		$value = base64_decode($value);
		$iv = substr($value, 0, $iv_length);
		$value = substr($value, $iv_length);
		return openssl_decrypt($value, $this->cipher, $key, OPENSSL_RAW_DATA, $iv);
	}
}
