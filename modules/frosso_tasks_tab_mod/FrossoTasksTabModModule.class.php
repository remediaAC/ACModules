<?php

// Include applicaiton specific module base
require_once APPLICATION_PATH . '/resources/ActiveCollabProjectSectionModule.class.php';

class FrossoTasksTabModModule extends ActiveCollabProjectSectionModule{
	
	/**
	 * Active module
	 *
	 * @var string
	 */
	protected $active_module = 'frosso_tasks_tab_mod';
	
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	 */
	protected $name = 'frosso_tasks_tab_mod';
	
	/*
	 * Versione
	 */
	protected $version = '0.8';
	
	/**
	 * Name of the project object class (or classes) that this module uses
	 *
	 * @var string
	 */
	//protected $project_object_classes = 'Task';
	
	public function getDisplayName(){
		return lang('TasksTabMod - FRosso per reMedia');
	}
	
	public function getDescription(){
		return lang("Modifica la tab dei tasks per includere anche le informazioni sul responsabile del task");
	}
	
	function defineRoutes(){
		
		// Hijacked Route
		Router::map('project_tasks', 'projects/:project_slug/tasks', array('controller' => 'frosso_tasks_tab_mod', 'action' => 'index'));
		
		// Single task
		// Servono perchè se viene salvato un task tra i preferiti, viene caricata la view dei tasks di default, senza il responsabile
		Router::map('project_task', 'projects/:project_slug/tasks/:task_id', array('controller' => 'frosso_tasks_tab_mod', 'action' => 'view'), array('task_id' => Router::MATCH_ID));
		Router::map('project_task_edit', 'projects/:project_slug/tasks/:task_id/edit', array('controller' => 'frosso_tasks_tab_mod', 'action' => 'edit'), array('task_id' => Router::MATCH_ID));
		
  		Router::map('frosso_tasks_tab_route', 'projects/:project_slug/tasks-old', array('controller' => 'tasks', 'action' => 'index', 'module' => TASKS_MODULE));
	}
	
	function defineHandlers(){
		EventsManager::listen('on_project_tabs', 'on_project_tabs');
		EventsManager::listen('on_available_project_tabs', 'on_available_project_tabs');
	}
}