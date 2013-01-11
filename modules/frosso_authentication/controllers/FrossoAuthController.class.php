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
		$params = ($this->request->get('params', false));
		if($params) {
			$rsa = new Crypt_RSA();
			
			$my_pub_key = ConfigOptions::getValue('frosso_auth_my_pub_key');
			$my_pri_key = ConfigOptions::getValue('frosso_auth_my_pri_key');
			
			$rsa->loadKey($my_pri_key);
			$decrypted_params = $rsa->decrypt($params);
			if ($decrypted_params) {
				list($email, $token, $timestamp) = explode(';', $decrypted_params);
				if ($email && $token && $timestamp) {
					if ($token == 'remedia' && (time() - 60*10 ) < $timestamp && $timestamp < (time() + 60*10)) {
						Authentication::useProvider('FrossoProvider', false);
						Authentication::getProvider()->initialize(array(
						'sid_prefix' => AngieApplication::getName(),
						'secret_key' => AngieApplication::getAdapter()->getUniqueKey(),
						));
						Authentication::getProvider()->authenticate($email);
					} else {
						$this->response->forbidden();
					} // token non valido
				} else {
					$this->response->badRequest(array('message' => 'Parametri non '));
				} // parametri non validi
			} else {
				$this->response->badRequest(array('message' => 'Parametri non validi'));
			}
		} else {
			$this->response->badRequest(array('message' => 'Parametri non settati'));
		} // parametri non settati
	}
}