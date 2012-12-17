<?php

// We need projects controller
AngieApplication::useController('project', SYSTEM_MODULE);

class FrossoTabController extends ProjectController{

	/**
	 * Default ordering of milestones
	 *
	 * @var string
	 */
	static private $order_milestones_by = 'NOT ISNULL(completed_on), ISNULL(date_field_1), date_field_1, position, created_on';
	
	static $priority_map = array(
				PRIORITY_HIGHEST	=> 'highest',
				PRIORITY_HIGH		=> 'high',
				PRIORITY_NORMAL		=> 'normal',
				PRIORITY_LOW		=> 'low',
				PRIORITY_LOWEST		=> 'lowest'
		);
	
	static $task_order_by = 'o.id';
	static $task_sort_by = 'desc';
	
	/**
	 * Construct controller
	 *
	 * @param Request $parent
	 * @param mixed $context
	 */
	function __construct($parent, $context = null) {
		parent::__construct($parent, $context);
		
		if($this->getControllerName() == 'frosso_tab') {
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
		
		
		$this->wireframe->tabs->setCurrentTab('fred_pt');
		
		$this->wireframe->breadcrumbs->add('frosso_tab_route', lang('FRed tab'), Router::assemble('frosso_tab_route', array('project_slug' => $this->active_project->getSlug())));
		
	}
	
	function index(){
		parent::index();
		
		$this->sorting_by();
		$this->order_name_by();
		
		if($this->request->get('order_name')){
			$this->wireframe->breadcrumbs->add('frosso_tab_route_order', $this->request->get('order_name'),
					Router::assemble('frosso_tab_route_order', array(
							'project_slug'	=> $this->active_project->getSlug(),
							'order_name'	=> $this->smarty->getVariable('order_name')
					)));
			$this->wireframe->breadcrumbs->add('frosso_tab_route_order_custom', self::$task_sort_by,
					Router::assemble('frosso_tab_route_order_custom', array(
							'project_slug'	=> $this->active_project->getSlug(),
							'order_name'	=> $this->smarty->getVariable('order_name'),
							'sorting'		=> self::$task_sort_by
					)));
		}
				
		$tasks =  self::findForOutline($this->active_project, $this->logged_user);
		
		$milestones = self::getNotEmptyIdNameMap($this->active_project);
        $milestones[0] = lang('Unknown Milestone');
                
        $this->response->assign('tasks', $tasks);
        $this->response->assign('map', $milestones);
		
	}
	
	function order_name_by(){
		$order_name =  $this->request->get('order_name');
		
		switch ($order_name) {
			case 'label':
				self::$task_order_by = 'o.label_id';
				$this->smarty->assign('order_name', 'label');
				break;
			case 'priority':
				self::$task_order_by = 'o.priority';
				$this->smarty->assign('order_name', 'priority');
				break;
			case 'due_on':
				self::$task_order_by = 'o.due_on';
				$this->smarty->assign('order_name', 'due_on');
				break;
			case 'updated_on':
				self::$task_order_by = 'o.updated_on';
				$this->smarty->assign('order_name', 'updated_on');
				break;
			case 'responsible':
				self::$task_order_by = 'u.first_name, u.last_name';
				$this->smarty->assign('order_name', 'responsible');
				break;
			case 'id': //id = default
			default:
				self::$task_order_by = 'o.id';
				$this->smarty->assign('order_name', 'id');
				break;
		}

	}
	
	function sorting_by(){
		
		self::$task_sort_by =  strtolower($this->request->get('sorting')) == 'asc' ? "asc" : "desc";
		
	}
	
	/**
	 * Returns ID name map
	 *
	 * $filter can be:
	 *
	 * - Project instance, only milestones from that project will be returned
	 * - NULL, in that case all milestones with given state will be returned
	 *
	 * @param mixed $filter
	 * @param integer $min_state
	 * @return array
	 */
	static function getNotEmptyIdNameMap($filter = null, $min_state = STATE_VISIBLE) {
		if($filter instanceof Project) {
			$rows = DB::execute('SELECT id, name FROM ' . TABLE_PREFIX . 'project_objects WHERE project_id = ? AND type = ? AND state >= ? 
					AND id IN (SELECT milestone_id FROM '.TABLE_PREFIX.'project_objects WHERE project_id = ? AND type = ? AND completed_on IS NULL GROUP BY milestone_id) 
					ORDER BY ' . self::$order_milestones_by, $filter->getId(), 'Milestone', $min_state, $filter->getId(), 'Task');
		} else {
			$rows = DB::execute('SELECT id, name FROM ' . TABLE_PREFIX . 'project_objects WHERE type = ? AND state >= ? ORDER BY ' . self::$order_milestones_by, 'Milestone', $min_state);
		} // if
	
		if(is_foreachable($rows)) {
			$result = array();
	
			foreach($rows as $row) {
				$result[(integer) $row['id']] = $row['name'];
			} // foreach
	
			return $result;
		} else {
			return null;
		} // if
	} // getNotEmptyIdNameMap
	
	/**
	 * Find tasks for outline
	 *
	 * @param Project $project
	 * @param User $user
	 * @param int $state
	 * @return array
	 */
	static function findForOutline(Project $project, User $user, $state = STATE_VISIBLE) {
		
		$today = strtotime(date('Y-m-d'));
		
		$task_ids = DB::executeFirstColumn('SELECT id 
				FROM ' . TABLE_PREFIX . 'project_objects 
				WHERE project_id = ? 
				AND type = ? 
				AND state >= ? 
				AND visibility >= ? 
				AND completed_on IS NULL', 
				$project->getId(), 'Task', $state, $user->getMinVisibility()
				);
	
		if (!is_foreachable($task_ids)) {
			return false;
		} // if
	
		$tasks = DB::execute('SELECT o.id, 
				o.integer_field_1 AS task_id, 
				o.name, 
				o.body, 
				o.due_on, 
				o.date_field_1 AS start_on, 
				o.assignee_id, 
				o.priority, 
				o.visibility, 
				o.created_by_id, 
				o.label_id, 
				o.milestone_id,
				o.category_id, 
				o.completed_on, 
				o.delegated_by_id, 
				o.state, 
				o.created_on, 
				o.updated_on,
				o.due_on,
				u.first_name,
				u.last_name 
				FROM ' . TABLE_PREFIX . 'project_objects o LEFT JOIN ' . TABLE_PREFIX . 'users u ON(o.assignee_id=u.id) 
				WHERE o.ID IN(?) ORDER BY ' . self::$task_order_by .' ' .self::$task_sort_by, $task_ids);
	
		// casting
// 		$tasks->setCasting(array(
// 				'due_on'        => DBResult::CAST_DATE,
// 				'start_on'      => DBResult::CAST_DATE
// 		));
	
		$tasks_id_prefix_pattern = '--TASK-ID--';
		$task_url_params = array('project_slug' => $project->getSlug(), 'task_id' => $tasks_id_prefix_pattern);
		$view_task_url_pattern = Router::assemble('project_task', $task_url_params);
		$edit_task_url_pattern = Router::assemble('project_task_edit', $task_url_params);
		$trash_task_url_pattern = Router::assemble('project_task_trash', $task_url_params);
		$subscribe_task_url_pattern = Router::assemble('project_task_subscribe', $task_url_params);
		$unsubscribe_task_url_pattern = Router::assemble('project_task_unsubscribe', $task_url_params);
		$reschedule_task_url_pattern = Router::assemble('project_task_reschedule', $task_url_params);
		$tracking_task_url_pattern = Router::assemble('project_task_tracking', $task_url_params);
	
		// can_manage_tasks
		$can_manage_tasks = ($user->projects()->getPermission('task', $project) >= ProjectRole::PERMISSION_MANAGE);
	
		// all assignees
		$user_assignments_on_tasks = DB::executeFirstColumn('SELECT parent_id FROM ' . TABLE_PREFIX . 'assignments WHERE parent_id IN (?) AND parent_type = ? AND user_id = ?', $task_ids, 'Task', $user->getId());
	
		// all subscriptions
		$user_subscriptions_on_tasks = DB::executeFirstColumn('SELECT parent_id FROM ' . TABLE_PREFIX . 'subscriptions WHERE parent_id IN (?) AND parent_type = ? AND user_id = ?', $task_ids, 'Task', $user->getId());
	
		// other assignees
		$other_assignees = array();
		$raw_other_assignees = DB::execute('SELECT user_id, parent_id FROM ' . TABLE_PREFIX . 'assignments WHERE parent_type = ? AND parent_id IN (?)', 'Task', $task_ids);
		foreach ($raw_other_assignees as $raw_assignee) {
			if (!is_array($other_assignees[$raw_assignee['parent_id']])) {
				$other_assignees[$raw_assignee['parent_id']] = array();
			} // if
			$other_assignees[$raw_assignee['parent_id']][] = array('id' => $raw_assignee['user_id']);
		} // foreach
	
		// expenses & time
		$expenses = array();
		$time = array();
		$estimates = array();
		if (AngieApplication::isModuleLoaded('tracking')) {
			$raw_expenses = DB::execute('SELECT parent_id, SUM(value) as expense FROM ' . TABLE_PREFIX . 'expenses WHERE parent_id IN (?) AND parent_type = ? GROUP BY parent_id', $task_ids, 'Task');
			if (is_foreachable($raw_expenses)) {
				foreach ($raw_expenses as $raw_expense) {
					$expenses[$raw_expense['parent_id']] = $raw_expense['expense'];
				} // if
			} // if
	
			$raw_time = DB::execute('SELECT parent_id, SUM(value) as time FROM ' . TABLE_PREFIX . 'time_records WHERE parent_id IN (?) AND parent_type = ? GROUP BY parent_id', $task_ids, 'Task');
			if (is_foreachable($raw_time)) {
				foreach ($raw_time as $raw_single_time) {
					$time[$raw_single_time['parent_id']] = $raw_single_time['time'];
				} // foreach
			} // if
	
			$raw_estimates = DB::execute('SELECT parent_id, value, job_type_id FROM (SELECT * FROM ' . TABLE_PREFIX . 'estimates WHERE parent_id IN (?) AND parent_type = ? ORDER BY created_on DESC) as estimates_inverted GROUP BY parent_id', $task_ids , 'Task');
			if (is_foreachable($raw_estimates)) {
				foreach ($raw_estimates as $raw_estimate) {
					$estimates[$raw_estimate['parent_id']] = array(
							'value' => $raw_estimate['value'],
							'job_type_id' => $raw_estimate['job_type_id'],
					);
				} // foreach
			} // if
		} // if
		
		$task_url = Router::assemble('project_task', array('project_slug' => $project->getSlug(), 'task_id' => '--TASKID--'));
		$project_id = $project->getId();
		
		$labels = Labels::getIdDetailsMap('AssignmentLabel');

		$results = array();
		foreach ($tasks as $subobject) {
			$task_id = array_var($subobject, 'id');
			$task_task_id = array_var($subobject, 'task_id');
			
			list($total_subtasks, $open_subtasks) = ProjectProgress::getObjectProgress(array(
					'project_id' => $project_id,
					'object_type' => 'Task',
					'object_id' => $subobject['id'],
			));
	
			$results[] = array(
					'id'                  => $task_id,
					'task_id'             => $task_task_id,
					'name'                => array_var($subobject, 'name'),
					'body'                => array_var($subobject, 'body'),
					'priority'            => array_var($subobject, 'priority'),
					'milestone_id'        => array_var($subobject, 'milestone_id', null),
					'class'               => 'Task',
					'start_on'            => array_var($subobject, 'start_on'),
					'assignee_id'         => array_var($subobject, 'assignee_id'),
					'other_assignees'     => array_var($other_assignees, $task_id, null),
					'label_id'            => array_var($subobject, 'label_id', null),
					'label'               => $subobject['label_id'] ? $labels[$subobject['label_id']] : null,
					'project_id'          => $project_id,
					'category_id'         => $subobject['category_id'],
					'is_completed'        => $subobject['completed_on'] ? 1 : 0,
					'permalink'           => str_replace('--TASKID--', $subobject['task_id'], $task_url),
					'priority'            => self::$priority_map[$subobject['priority']],
					'delegated_by_id'     => $subobject['delegated_by_id'],
					'total_subtasks'      => $total_subtasks,
					'open_subtasks'       => $open_subtasks,
					'is_favorite'         => Favorites::isFavorite(array('Task', $task_id), $user),
					'is_archived'         => $subobject['state'] == STATE_ARCHIVED ? 1 : 0,
					'visibility'          => $subobject['visibility'],
					'created_on'		  => $subobject['created_on'] ? $subobject['created_on'] : $subobject['updated_on'],
					'updated_on'		  => $subobject['updated_on'],
					'assignee_name'		  => $subobject['first_name'] . " " . $subobject['last_name'],
					'due_on'			  => $subobject['due_on'] ? $subobject['due_on'] : lang('No due date set'),
					'stato'				  => $subobject['due_on'] ? ($subobject['due_on'] >= $today ? 'orario' : 'ritardo') : 'not_set', //se c'è la data di scadenza, controllo che sia nel futuro, altrimenti il task è in ritardo
					'user_is_subscribed'  => in_array($task_id, $user_subscriptions_on_tasks),
					'object_time'         => array_var($time, $task_id, 0),
					'object_expenses'     => array_var($expenses, $task_id, 0),
					'estimate'            => array_var($estimates, $task_id, null),
					'event_names'         => array(
							'updated'             => 'task_updated'
					),
					'urls'                => array(
							'view'                => str_replace($tasks_id_prefix_pattern, $task_task_id, $view_task_url_pattern),
							'edit'                => str_replace($tasks_id_prefix_pattern, $task_task_id, $edit_task_url_pattern),
							'trash'               => str_replace($tasks_id_prefix_pattern, $task_task_id, $trash_task_url_pattern),
							'subscribe'           => str_replace($tasks_id_prefix_pattern, $task_task_id, $subscribe_task_url_pattern),
							'unsubscribe'         => str_replace($tasks_id_prefix_pattern, $task_task_id, $unsubscribe_task_url_pattern),
							'reschedule'          => str_replace($tasks_id_prefix_pattern, $task_task_id, $reschedule_task_url_pattern),
							'tracking'            => str_replace($tasks_id_prefix_pattern, $task_task_id, $tracking_task_url_pattern),
					),
					'permissions'         => array(
							'can_edit'            => can_edit_project_object($subobject, $user, $project, $can_manage_tasks, $user_assignments_on_tasks),
							'can_trash'           => can_trash_project_object($subobject, $user, $project, $can_manage_tasks, $user_assignments_on_tasks),
					)
			);
		} // foreach
	
		return $results;
	} // findForOutline
	
}