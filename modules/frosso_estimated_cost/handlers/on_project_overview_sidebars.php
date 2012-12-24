<?php

  /**
   * Time Reports Plus module on_project_overview_sidebars event handler
   *
   * @package custom.modules.time_reports_plus
   * @subpackage handlers
   */
  
  /**
   * Add sidebars to project overview page
   *
   * @param array $sidebars
   * @param Project $project
   * @param User $user
   */
  function frosso_estimated_cost_handle_on_project_overview_sidebars(&$sidebars, Project &$project, User &$user) {
    if($user->canUseReports() || $project->isLeader($user)){
	    $arguments = array(
        	'conditions' => array(
        			'project_id = ? AND type = ? AND state >= ? AND visibility >= ? AND completed_on IS NULL', 
        			$project->getId(), 'Milestone', STATE_VISIBLE, VISIBILITY_NORMAL
        			)
      	);
	    $milestones = DataManager::find($arguments, TABLE_PREFIX . 'project_objects', DataManager::CLASS_NAME_FROM_TABLE, 'RemediaMilestone');
	    
	    if(is_foreachable($milestones)) {
	    	$result = array();
		    $view = SmartyForAngie::getInstance()->createTemplate(
		    		AngieApplication::getViewPath(
		    				'eta_project_sidebar', 
		    				'sidebar', 
		    				FROSSO_EC_MODULE, 
		    				AngieApplication::INTERFACE_DEFAULT)
		    		);
		    $view->assign(array(
		    		'milestones' => $milestones
		    ));
		  	$sidebars[] = array(
			        'label' => lang('ETA for this project'),
			        'is_important'  => false,
			        'id' => 'project_milestones_complete',
			        'body' => $view->fetch(),
		        );
	    }     
    }
   
  } // frosso_estimated_cost_handle_on_project_overview_sidebars