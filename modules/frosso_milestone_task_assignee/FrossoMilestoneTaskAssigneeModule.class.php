<?php
// Include applicaiton specific module base
require_once APPLICATION_PATH . '/resources/ActiveCollabProjectSectionModule.class.php';

class FrossoMilestoneTaskAssigneeModule extends AngieModule{
	/*
	 * Nome del modulo, dev'essere uguale al nome della cartella
	 */
	protected $name = 'frosso_milestone_task_assignee';
	
	/*
	 * Versione
	 */
	protected $version = '0.6';
	
	/**
	 * Name of the project object class (or classes) that this module uses
	 *
	 * @var string
	 */
	protected $project_object_classes = 'Task';
	
	public function getDisplayName(){
		return lang('Milestone Task Assignee - FRosso per reMedia');
	}
	
	public function getDescription(){
		return lang("Modulo creato per visualizzare l\'assegnatario di un Task");
	}
	
	function defineRoutes(){
		//overwriten route activecollab/[versione]/modules/tasks/TasksModule.class.php
 		Router::map('milestone_tasks', 'projects/:project_slug/milestones/:milestone_id/tasks', array('controller' => 'frosso_milestone_task_assignee', 'action' => 'index'), array('milestone_id' => Router::MATCH_ID));
	}
	
	function defineHandlers(){
		EventsManager::listen('on_milestone_sections', 'on_milestone_sections');
	}
}