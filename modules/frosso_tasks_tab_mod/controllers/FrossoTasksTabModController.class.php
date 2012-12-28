<?php

AngieApplication::useController('tasks_plus', TASKS_PLUS_MODULE);

class FrossoTasksTabModController extends TasksPlusController {
	
	static $priorities_map = array(
			PRIORITY_HIGHEST	=> 'highest',
			PRIORITY_HIGH		=> 'high',
			PRIORITY_NORMAL		=> 'normal',
			PRIORITY_LOW		=> 'low',
			PRIORITY_LOWEST		=> 'lowest'
	);
	
	/**
	 * Construct controller
	 *
	 * @param Request $parent
	 * @param mixed $context
	 */
	function __construct($parent, $context = null) {
		parent::__construct($parent, $context);
	
		if($this->getControllerName() == 'frosso_tasks_tab_mod') {
			//$this->categories_delegate = $this->__delegate('categories', CATEGORIES_FRAMEWORK_INJECT_INTO, 'project_asset');
		}
	
	}
	
	/**
	 * Prepare controller
	 */
	function __before(){
		parent::__before();
	
		if(!Tasks::canAccess($this->logged_user, $this->active_project)) {
			$this->response->forbidden();
		} // if
	
		// load project tabs
		//$project_tabs = $this->active_project->getTabs($this->logged_user, AngieApplication::INTERFACE_DEFAULT);
	
	
		$this->wireframe->tabs->setCurrentTab('tasks_mod');
	
		$this->wireframe->breadcrumbs->add('frosso_tasks_tab_route', lang('TasksMod'), Router::assemble('frosso_tasks_tab_route', array('project_slug' => $this->active_project->getSlug())));
	
	}
	
	function index() {
		parent::index();
		
		$this->response->assign(array(
				'tasks' => self::findForObjectsList($this->active_project, $this->logged_user)
		));
	}
	
	/**
	 * Find all tasks in project, and prepare them for objects list
	 *
	 * @param Project $project
	 * @param User $user
	 * @param int $state
	 * @return array
	 */
	static function findForObjectsList(Project $project, User $user, $state = STATE_VISIBLE) {
		$result = array();
		$today = strtotime(date('Y-m-d'));
	
		$tasks = DB::execute("SELECT o.id, o.name,
						o.category_id,
						o.milestone_id,
						o.completed_on,
						o.integer_field_1 as task_id,
						o.label_id,
						o.assignee_id,
						o.priority,
						o.delegated_by_id,
						o.state,
						o.visibility,
						o.created_on,
						o.updated_on,
						o.due_on,
						u.first_name,
						u.last_name,
						es.estimated_time,
						rec.tracked_time
					FROM " . TABLE_PREFIX . "project_objects o LEFT JOIN " . TABLE_PREFIX . "users u ON(o.assignee_id=u.id)
					LEFT JOIN (SELECT parent_id, value AS estimated_time FROM " . TABLE_PREFIX . "estimates GROUP BY parent_id ORDER BY created_on DESC) es ON(o.id=es.parent_id)
					LEFT JOIN (SELECT parent_id, sum(value) tracked_time FROM " . TABLE_PREFIX . "time_records WHERE state = ? GROUP BY(parent_id)) rec ON(o.id=rec.parent_id)
					WHERE o.type = 'Task' AND o.project_id = ? AND o.state = ? AND o.visibility >= ?"
				, $state, $project->getId(), $state, $user->getMinVisibility());
		if (is_foreachable($tasks)) {
			$task_url = Router::assemble('project_task', array('project_slug' => $project->getSlug(), 'task_id' => '--TASKID--'));
			$project_id = $project->getId();
	
			$labels = Labels::getIdDetailsMap('AssignmentLabel');
	
			foreach ($tasks as $task) {
					list($total_subtasks, $open_subtasks) = ProjectProgress::getObjectProgress(array(
							'project_id' => $project_id,
							'object_type' => 'Task',
							'object_id' => $task['id'],
					));
	
					$taskObj = new Task($task['id']);
					
					$result[] = array(
							'id'                => $task['id'],
							'name'              => $task['name'],
							'project_id'        => $project_id,
							'category_id'       => $task['category_id'],
							'milestone_id'      => $task['milestone_id'],
							'task_id'           => $task['task_id'],
							'is_completed'      => $task['completed_on'] ? 1 : 0,
							'permalink'         => str_replace('--TASKID--', $task['task_id'], $task_url),
							'label_id'          => $task['label_id'],
							'label'             => $task['label_id'] ? $labels[$task['label_id']] : null,
							'assignee_id'       => $task['assignee_id'],
							'priority'          => $task['priority'],
							'delegated_by_id'   => $task['delegated_by_id'],
							'total_subtasks'    => $total_subtasks,
							'open_subtasks'     => $open_subtasks,
							'estimated_time'    => $taskObj->tracking()->canAdd($user) 	? $task['estimated_time'] 	: 0,
							'tracked_time'      => $taskObj->tracking()->canAdd($user) 	? $task['tracked_time'] 	: 0,
							'is_favorite'       => Favorites::isFavorite(array('Task', $task['id']), $user),
							'is_archived'       => $task['state'] == STATE_ARCHIVED ? 1 : 0,
							'visibility'        => $task['visibility'],
							'created_on'		=> $task['created_on'] ? $task['created_on'] : $task['updated_on'],
							'updated_on'		=> $task['updated_on'],
													// Se non c'è il cognome, tengo il nome per esteso. Altrimenti abbrevio il nome al primo carattere.
							'assignee_name'		=> ($task['last_name'] ? substr($task['first_name'], 0, 1) . "." : $task['first_name'] ) . ($task['last_name'] ? " " . $task['last_name'] :""),
							'due_on'			=> $task['due_on'] ? $task['due_on'] : lang('No due date set'),
							'stato'				=> $task['due_on'] ? ($task['due_on'] >= $today ? 'orario' : 'ritardo') : 'not_set' //se c'è la data di scadenza, controllo che sia nel futuro, altrimenti il task è in ritardo
					);
			} // foreach
		} // if
	
		return $result;
	} // findForObjectsList
	
}