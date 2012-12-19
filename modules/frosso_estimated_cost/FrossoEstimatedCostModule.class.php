<?php

class FrossoEstimatedCostModule extends AngieModule {
	/**
	 * Active module
	 *
	 * @var string
	 */
	protected $active_module = FROSSO_EC_MODULE;
	
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	*/
	protected $name = 'frosso_estimated_cost';
	
	/*
	 * Versione
	*/
	protected $version = '0.1';
	
	public function getDisplayName(){
		return lang('Aggiunge la stima temporale alle milestone e la percentuale di completamento');
	}
	
	public function getDescription(){
		return lang("Modulo creato per reMedia");
	}
	
	function defineRoutes(){
		Router::map('frosso_estimated_cost_reports', 'reports/frosso-ecr', array('controller' => 'frosso_estimated_cost_reports', 'action' => 'index'));
	}
	
	function defineHandlers(){
// 		EventsManager::listen('on_homescreen_widget_types', 'on_homescreen_widget_types');
		EventsManager::listen('on_reports_panel', 'on_reports_panel');
	}
}