<?php

  /**
   * Frosso Tasks Tab Mod module on_project_tabs event handler
   */
  
  /**
   * Handle on prepare project overview event
   *
   * @param NamedList $tabs
   * @param User $logged_user
   * @param Project $project
   * @param array $tabs_settings
   * @param string $interface
   */
function frosso_tasks_tab_mod_handle_on_project_tabs(&$tabs, &$logged_user, &$project, &$tabs_settings, $interface) {
    if($interface == AngieApplication::INTERFACE_DEFAULT && Tasks::canAccess($logged_user, $project, false) && in_array('fred_pt', $tabs_settings)) {
	  	$tabs->addBefore('tasks_mod', array(
	  			'text'	=> "OldTasks",
	  			'url'	=> Router::assemble('frosso_tasks_tab_route', array('project_slug' => $project->getSlug())),
	  			'icon' => $interface == AngieApplication::INTERFACE_DEFAULT ?
	  			AngieApplication::getImageUrl('icons/16x16/tasks-tab-icon.png', TASKS_MODULE) :
	  			AngieApplication::getImageUrl('icons/listviews/tasks.png', TASKS_MODULE, AngieApplication::INTERFACE_PHONE)
	  			),
	  			'tasks'
	  			);
    } // if
} // frosso_tasks_tab_mod_handle_on_project_tabs