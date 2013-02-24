<?php

  // Include application specific model base
  require_once APPLICATION_PATH . '/resources/ActiveCollabModuleModel.class.php';

  /**
   * Status module model definition
   *
   * @package activeCollab.modules.status
   * @subpackage resources
   */
  class FrossoMailNotifyModuleModel extends ActiveCollabModuleModel {
    
    /**
     * Construct status module model definition
     *
     * @param StatusModule $parent
     */
    function __construct(StatusModule $parent) {
      parent::__construct($parent);
    } // __construct
    
    /**
     * Load initial module data
     *
     * @param string $environment
     */
    function loadInitialData($environment = null) {
      $this->addConfigOption('fmn_last_visited');
      
      parent::loadInitialData($environment);
    } // loadInitialData
    
  }