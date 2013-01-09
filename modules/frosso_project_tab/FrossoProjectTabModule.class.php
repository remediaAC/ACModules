<?php

// Include applicaiton specific module base
require_once APPLICATION_PATH . '/resources/ActiveCollabProjectSectionModule.class.php';

class FrossoProjectTabModule extends ActiveCollabProjectSectionModule{
	
	/**
	 * Active module
	 *
	 * @var string
	 */
	protected $active_module = 'frosso_project_tab';
	
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	 */
	protected $name = 'frosso_project_tab';
	
	/*
	 * Versione
	 */
	protected $version = '0.4';
	
	/**
	 * Name of the project object class (or classes) that this module uses
	 *
	 * @var string
	 */
	//protected $project_object_classes = 'Task';
	
	public function getDisplayName(){
		return lang('ProjectTab - FRosso per reMedia');
	}
	
	public function getDescription(){
		return lang("Modulo creato per aggiungere una tab customizzata con l'ordinamento dei task aperti");
	}
	
	function defineRoutes(){
 		Router::map('frosso_tab_route', 'projects/:project_slug/frosso-tab', array('controller' => 'frosso_tab', 'action' => 'index'));
 		Router::map('frosso_tab_route_order', 'projects/:project_slug/frosso-tab/:order_name', array('controller' => 'frosso_tab', 'action' => 'index'));
 		Router::map('frosso_tab_route_order_custom', 'projects/:project_slug/frosso-tab/:order_name/:sorting', array('controller' => 'frosso_tab', 'action' => 'index'));
	}
	
	function defineHandlers(){
		EventsManager::listen('on_project_tabs', 'on_project_tabs');
		EventsManager::listen('on_available_project_tabs', 'on_available_project_tabs');
	}
}