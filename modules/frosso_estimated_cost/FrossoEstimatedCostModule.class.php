<?php

class FrossoEstimatedCostModule extends AngieModule {
	/**
	 * Active module
	 *
	 * @var string
	 */
	protected $active_module = 'frosso_estimated_cost';
	
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	*/
	protected $name = 'frosso_estimated_cost';
	
	/*
	 * Versione
	*/
	protected $version = '0.3';
	
	public function getDisplayName(){
		return lang('Milestone ETA - FRosso per reMedia');
	}
	
	public function getDescription(){
		return lang("Aggiunge la stima temporale alle milestone e la percentuale di completamento");
	}
	
	function defineRoutes(){
		Router::map('frosso_estimated_cost_reports', 'reports/frosso-ecr', array('controller' => 'frosso_estimated_cost_reports', 'action' => 'index'));
		Router::map('frosso_testing_route', 'reports/frosso-test', array('controller' => 'frosso_testing', 'action' => 'index'));
		
		Router::map('frosso_ec_set_milestone_percent', 'projects/:project_slug/milestones/:milestone_id/percent/set', array('controller' => 'milestones_tracking', 'action' => 'set_percent'));
		
		// Hijacked Routes
		Router::map('project_milestones', 'projects/:project_slug/milestones', array('controller' => 'milestones_tracking', 'action' => 'index'));
		Router::map('project_milestone', 'projects/:project_slug/milestones/:milestone_id', array('controller' => 'milestones_tracking', 'action' => 'view'), array('milestone_id' => Router::MATCH_ID));
		Router::map('project_milestones_add', 'projects/:project_slug/milestones/add', array('controller' => 'milestones_tracking', 'action' => 'add'));
		Router::map('project_milestone_edit', 'projects/:project_slug/milestones/:milestone_id/edit', array('controller' => 'milestones_tracking', 'action' => 'edit'), array('milestone_id' => Router::MATCH_ID));
		Router::map('project_object_update_milestone', 'projects/:project_slug/objects/:object_id/update-milestone', array('controller' => 'milestones_tracking', 'action' => 'update_milestone'), array('object_id' => Router::MATCH_ID));
		
		// Tracking
		if(AngieApplication::isModuleLoaded('tracking')) {
			// prefisso, url, nome controller, nome modulo, parametri extra
			AngieApplication::getModule('tracking')->defineTrackingRoutesFor('project_milestone', 'projects/:project_slug/milestones/:milestone_id', 'milestones_tracking', FROSSO_EC_MODULE, array('milestone_id' => Router::MATCH_ID));
		} // if
		
	}
	
	function defineHandlers(){
// 		EventsManager::listen('on_homescreen_widget_types', 'on_homescreen_widget_types');
		EventsManager::listen('on_reports_panel', 'on_reports_panel');
		EventsManager::listen('on_project_overview_sidebars', 'on_project_overview_sidebars');
		EventsManager::listen('on_before_object_validation', 'on_before_object_validation');
		EventsManager::listen('on_after_object_save', 'on_after_object_save');
		EventsManager::listen('on_object_inspector', 'on_object_inspector');
	}
	
	function install(){
		//Aggiunge il campo personalizzato percentuale completamento
		try {
			FwCustomFields::initForType('RemediaMilestone');
			$settings = array(
					'custom_field_1' =>array(
								'is_enabled' 	=> 1,
								'label'			=> 'Percent Complete'
							)
					);
			FwCustomFields::setCustomFieldsByType('RemediaMilestone', $settings);
		} catch (Exception $e) {
			try{
			// Workaround for AC *buggy* code :) (until AC devs will fix it)
			DB::execute('INSERT INTO ' . TABLE_PREFIX . 'custom_fields (`field_name`, `parent_type`, `label`, `is_enabled`)
					VALUES (\'custom_field_1\', \'RemediaMilestone\', \'Percent Complete\', 1)');
			DB::execute('INSERT INTO ' . TABLE_PREFIX . 'custom_fields (`field_name`, `parent_type`, `label`, `is_enabled`)
					VALUES (\'custom_field_2\', \'RemediaMilestone\', \'NULL\', 0)');
			DB::execute('INSERT INTO ' . TABLE_PREFIX . 'custom_fields (`field_name`, `parent_type`, `label`, `is_enabled`)
					VALUES (\'custom_field_3\', \'RemediaMilestone\', \'NULL\', 0)');
			} catch (Exception $e) {}
		}
		return parent::install();
	}
	
}