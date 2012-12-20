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
		Router::map('frosso_testing_route', 'reports/frosso-test', array('controller' => 'frosso_testing', 'action' => 'index'));
	}
	
	function defineHandlers(){
// 		EventsManager::listen('on_homescreen_widget_types', 'on_homescreen_widget_types');
		EventsManager::listen('on_reports_panel', 'on_reports_panel');
	}
	
	function install(){
		//Aggiunge il campo personalizzato percentuale completamento
		try {
			FwCustomFields::initForType('Milestone');
			$settings = array(
					'custom_field_1' =>array(
								'is_enabled' 	=> 1,
								'label'			=> 'Percent Complete'
							)
					);
			FwCustomFields::setCustomFieldsByType('Milestone', $settings);
		} catch (Exception $e) {
			// Workaround for AC *buggy* code :) (until AC devs will fix it)
			DB::execute('INSERT INTO ' . TABLE_PREFIX . 'custom_fields (`field_name`, `parent_type`, `label`, `is_enabled`)
					VALUES (\'custom_field_1\', \'Milestone\', \'Percent Complete\', 1)');
			DB::execute('INSERT INTO ' . TABLE_PREFIX . 'custom_fields (`field_name`, `parent_type`, `label`, `is_enabled`)
					VALUES (\'custom_field_2\', \'Milestone\', \'NULL\', 0)');
			DB::execute('INSERT INTO ' . TABLE_PREFIX . 'custom_fields (`field_name`, `parent_type`, `label`, `is_enabled`)
					VALUES (\'custom_field_3\', \'Milestone\', \'NULL\', 0)');
		}
		return parent::install();
	}
	
}