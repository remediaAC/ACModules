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
	    $milestones = Milestones::findActiveByProject($project);
	    
	    if(is_foreachable($milestones)) {
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