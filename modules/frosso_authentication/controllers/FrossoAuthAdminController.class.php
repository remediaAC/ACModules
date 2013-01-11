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

			$this->smarty->assign(array(
					'my_pub_key' => $my_pub_key,
					'my_pri_key' => $my_pri_key
			));

			if($this->request->isSubmitted()){
				$my_pub_sub = $this->request->post('my_pub_key');
				$my_pri_sub = $this->request->post('my_pri_key');

				if (FrossoAuthModel::isValidKey($my_pub_sub, $my_pri_sub)) {
					ConfigOptions::setValue('frosso_auth_my_pub_key', $my_pub_sub);
					ConfigOptions::setValue('frosso_auth_my_pri_key', $my_pri_sub);

					$my_pub_key = $my_pub_sub;
					$my_pri_key = $my_pri_sub;
					$this->response->ok();
				} else {
					$this->response->exception(new ValidationErrors(array('my_pub_key' => lang("Public key and private key must be valid"))));
				}
			}// isSubmitted

		} else {
			$this->response->badRequest();
		} // if
	}

}