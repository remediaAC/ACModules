<?php
// Include applicaiton specific module base
require_once APPLICATION_PATH . '/resources/ActiveCollabProjectSectionModule.class.php';

class FrossoModule extends AngieModule{
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	 */
	protected $name = 'frosso';
	
	/*
	 * Versione
	 */
	protected $version = '0.4';
	
	/**
	 * Name of the project object class (or classes) that this module uses
	 *
	 * @var string
	 */
	protected $project_object_classes = 'Task';
	
	public function getDisplayName(){
		return lang('Modulo creato da FRosso');
	}
	
	public function getDescription(){
		return lang("Modulo creato per reMedia per visualizzare l\'assegnatario di un Task");
	}
	
	function defineRoutes(){
		//overwriten route activecollab/[versione]/modules/tasks/TasksModule.class.php
 		Router::map('tasks_frosso', 'projects/:project_slug/milestones/:milestone_id/tasks', array('controller' => 'frosso', 'action' => 'index'), array('milestone_id' => Router::MATCH_ID));
	}
	
	function defineHandlers(){
		EventsManager::listen('on_milestone_sections', 'on_milestone_sections');
	}
}