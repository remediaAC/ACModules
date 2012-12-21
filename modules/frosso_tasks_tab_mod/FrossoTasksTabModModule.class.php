<?php

// Include applicaiton specific module base
require_once APPLICATION_PATH . '/resources/ActiveCollabProjectSectionModule.class.php';

class FrossoTasksTabModModule extends ActiveCollabProjectSectionModule{
	
	/**
	 * Active module
	 *
	 * @var string
	 */
	protected $active_module = FROSSO_TTMOD_MODULE;
	
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	 */
	protected $name = 'frosso_tasks_tab_mod';
	
	/*
	 * Versione
	 */
	protected $version = '0.5';
	
	/**
	 * Name of the project object class (or classes) that this module uses
	 *
	 * @var string
	 */
	//protected $project_object_classes = 'Task';
	
	public function getDisplayName(){
		return lang('Modifica la tab dei tasks per incluedere anche le informazioni sul responsabile del task');
	}
	
	public function getDescription(){
		return lang("Modulo creato per reMedia per modificare il tab dei tasks");
	}
	
	function defineRoutes(){
  		Router::map('frosso_tasks_tab_route', 'projects/:project_slug/tasks-mod', array('controller' => 'frosso_tasks_tab_mod', 'action' => 'index'));
	}
	
	function defineHandlers(){
		EventsManager::listen('on_project_tabs', 'on_project_tabs');
		EventsManager::listen('on_available_project_tabs', 'on_available_project_tabs');
	}
}