<?php

// Build on top of framework authentication controller
AngieApplication::useController('fw_authentication', AUTHENTICATION_FRAMEWORK);

class FrossoAuthController extends FwAuthenticationController {
	/**
	 * Active module
	 *
	 * @var string
	 */
	protected $active_module = FROSSO_AUTH_MODULE;
	
	function __before() {
// 		parent::__before();
	}
	
	/**
	 * Log user in
	 */
	function login() {
		$email = trim($this->request->get('email'));
		if(!$email) die("Prego aggiungere email");
		Authentication::useProvider('FrossoProvider', false);
		Authentication::getProvider()->initialize(array(
		'sid_prefix' => AngieApplication::getName(),
		'secret_key' => AngieApplication::getAdapter()->getUniqueKey(),
		));
		Authentication::getProvider()->authenticate($email);
	}
}