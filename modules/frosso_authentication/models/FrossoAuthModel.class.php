<?php

class FrossoAuthModel {
	
	/**
	 * Return true if $pub_k and $pri_k encode and decode the same text
	 * 
	 * @param String $pub_k
	 * @param String $pri_k
	 * @return boolean
	 */
	static function isValidKey($pub_k, $pri_k) {
		
		$plaintext = 'pippopippo';
		
		$rsa = new Crypt_RSA();
		$rsa->loadKey($pub_k);
		$ciphertext = $rsa->encrypt($plaintext);
		
		$rsa->loadKey($pri_k);
		
		return ($plaintext == $rsa->decrypt($ciphertext));
		
	}
	
}