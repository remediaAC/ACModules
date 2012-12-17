<?php

// Include applicaiton specific module base
require_once APPLICATION_PATH . '/resources/ActiveCollabProjectSectionModule.class.php';

class FrossoGanttChartModule extends ActiveCollabProjectSectionModule{
	
	/**
	 * Active module
	 *
	 * @var string
	 */
	protected $active_module = FROSSO_GC_MODULE;
	
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	 */
	protected $name = 'frosso_gantt_chart';
	
	/*
	 * Versione
	 */
	protected $version = '0.1';
	
	public function getDisplayName(){
		return lang('Aggiunge Gantt Chart ai progetti');
	}
	
	public function getDescription(){
		return lang("Modulo creato per reMedia per aggiungere una tab customizzata");
	}
	
	function defineRoutes(){
 		Router::map('frosso_gc_route', 'projects/:project_slug/frosso-gc', array('controller' => 'frosso_gantt_chart', 'action' => 'index'));
	}
	
	function defineHandlers(){
		EventsManager::listen('on_project_tabs', 'on_project_tabs');
		EventsManager::listen('on_available_project_tabs', 'on_available_project_tabs');
	}
}