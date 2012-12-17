<?php

// We need projects controller
AngieApplication::useController('project', SYSTEM_MODULE);

class FrossoGanttChartController extends ProjectController{
	
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
	
		if(!Tasks::canAccess($this->logged_user, $this->active_project)) {
			$this->response->forbidden();
		} // if
	
		// load project tabs
		//$project_tabs = $this->active_project->getTabs($this->logged_user, AngieApplication::INTERFACE_DEFAULT);
	
	
		$this->wireframe->tabs->setCurrentTab('fred_gc');
	
		$this->wireframe->breadcrumbs->add('frosso_gc_route', lang('FRosso GC'), Router::assemble('frosso_gc_route', array('project_slug' => $this->active_project->getSlug())));
	}
	
	function index(){
		parent::index();
	}
	
}