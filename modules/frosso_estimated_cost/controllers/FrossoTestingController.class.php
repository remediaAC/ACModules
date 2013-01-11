<?php
// Build on top of reports module
AngieApplication::useController('reports', REPORTS_FRAMEWORK_INJECT_INTO);

class FrossoTestingController extends ReportsController {
	
	/**
	 * Index action
	 */
	function index() {
		
		$rsa = new Crypt_RSA();
		
		$rsa->loadKey(ConfigOptions::getValue('frosso_auth_my_pub_key'));
		
		$text = 'frosso@remedia.it;remedia;'.time();
		$crypt =  $rsa->encrypt($text);
		
		echo '<textarea cols="200">'.($crypt)."</textarea>";
		echo '<br/><textarea cols="200">'.urlencode($crypt)."</textarea>";
		
		$this->response->badRequest();

	}

}