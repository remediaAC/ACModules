<?php

AngieApplication::useController('tasks', TASKS_MODULE);

class FrossoTasksTabModController extends TasksController {

	/**
	 * Construct controller
	 *
	 * @param Request $parent
	 * @param mixed $context
	 */
	function __construct($parent, $context = null) {
		parent::__construct($parent, $context);
	}

	/**
	 * Prepare controller
	 */
	function __before(){
		parent::__before();
	}

	function index() {
		parent::index();

		$this->response->assign(array(
				'tasks' => FrossoModel::findForObjectsList($this->active_project, $this->logged_user)
		));
	}

	function view() {
		parent::view();
		//TODO: cambiare il template
	}

	function edit() {
		parent::edit();
	}

}