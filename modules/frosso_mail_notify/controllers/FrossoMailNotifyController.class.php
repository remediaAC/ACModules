<?php

  // Build on top of backend controller
  AngieApplication::useController('backend', ENVIRONMENT_FRAMEWORK_INJECT_INTO);

  /**
   * Status controller
   *
   * @package activeCollab.modules.status
   * @subpackage controllers
   */
  class FrossoMailNotifyController extends BackendController {
    
    /**
     * Active module
     *
     * @var string
     */
    protected $active_module = FROSSO_MAILN_MODULE;
	
    /**
     * Prepare controller
     */
    function __before() {
      parent::__before();
	  
	  $this->wireframe->breadcrumbs->add('frosso_activity', lang('Activities Updates'), Router::assemble('frosso_mail_notify'));
	  
	  $this->wireframe->tabs->add('frosso_activities', lang('Activities Updates'), Router::assemble('frosso_mail_notify'), false, true);
    } // __construct
    
    /**
     * Index page action
     */
    function index() {
      ConfigOptions::setValueFor('fmn_last_visited', $this->logged_user, new DateTimeValue());
	  
      // Popup
      if($this->request->isAsyncCall()) {
        $this->setView(array(
          'template' => 'popup',
          'controller' => 'frosso_mail_notify',
          'module' => FROSSO_MAILN_MODULE,
        ));
		
		// $this->response->assign(array(
          // 'mail_updates' => time(),
        // ));

	  } else {
	  	// $this->response->forbidden();
      } // if
    } // index
    
    /**
     * Provide ajax functionality for menu badge
     */
    function count_new_messages() {
      $this->renderText(NotificationsActivityLogs::countSinceLastVisit($this->logged_user));
    } // count_new_messages
    
  }