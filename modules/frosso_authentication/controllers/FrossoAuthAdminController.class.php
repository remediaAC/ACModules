<?php

// Build on top of administration controller
AngieApplication::useController('admin', SYSTEM_MODULE);

/**
 * Tasks administration controller
 *
 * @package activeCollab.modules.tasks
 * @subpackage controllers
*/
class FrossoAuthAdminController extends AdminController {

	function __construct($parent) {
		parent::__construct($parent);
	}

	function index() {
		if($this->request->isAsyncCall()) {
			$my_pub_key = ConfigOptions::getValue('frosso_auth_my_pub_key', false);
			$my_pri_key = ConfigOptions::getValue('frosso_auth_my_pri_key', false);
			$token		= ConfigOptions::getValue('frosso_auth_my_pri_token', false);

			$this->smarty->assign(array(
					'my_pub_key' => $my_pub_key,
					'my_pri_key' => $my_pri_key,
					'token'		 => $token
			));

			if($this->request->isSubmitted()){
				$my_pub_sub = $this->request->post('my_pub_key');
				$my_pri_sub = $this->request->post('my_pri_key');
				$sub_token	= $this->request->post('token');
				
				if($sub_token) {
					if (FrossoAuthModel::isValidKey($my_pub_sub, $my_pri_sub)) {
						ConfigOptions::setValue('frosso_auth_my_pub_key', $my_pub_sub);
						ConfigOptions::setValue('frosso_auth_my_pri_key', $my_pri_sub);
						ConfigOptions::setValue('frosso_auth_my_pri_token', $sub_token);

						$my_pub_key = $my_pub_sub;
						$my_pri_key = $my_pri_sub;
						$this->response->ok();
					} else {
						$this->response->exception(new ValidationErrors(array('my_pub_key' => lang("Public key and private key must be valid"))));
					}
				} else {
					$this->response->exception(new ValidationErrors(array('token' => lang("Token must be valid"))));
				}
			}// isSubmitted

		} else {
			$this->response->badRequest();
		} // if
	}

}