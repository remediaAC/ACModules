<?php
// We need projects controller
AngieApplication::useController('milestones', SYSTEM_MODULE);

/**
 * Tasks controller
 *
 * @package activeCollab.modules.tasks
 * @subpackage controllers
*/
class MilestonesTrackingController extends MilestonesController {
	/**
	 * Active module
	 *
	 * @var string
	 */
	protected $active_module = FROSSO_EC_MODULE;
	
	
	/**
	 * Object tracking controller delegate
	 *
	 * @var ObjectTrackingController
	 */
	protected $object_tracking_delegate;
	
	
	/**
	 * Milestone attiva
	 * 
	 * @var RemediaMilestone
	 */
	protected $active_milestone;
	
	/**
	 * Construct controller
	 *
	 * @param Request $parent
	 * @param mixed $context
	 */
	function __construct($parent, $context = null) {
		parent::__construct($parent, $context);

		if($this->getControllerName() == 'milestones_tracking') {
			if(AngieApplication::isModuleLoaded('tracking')) {
				$this->object_tracking_delegate = $this->__delegate('object_tracking', TRACKING_MODULE, 'project_milestone');
			} // if

		} // if
	} // __construct
	
	function __before() {
		parent::__before();
		
		$milestone_id = $this->request->getId('milestone_id');
		if($milestone_id) {
			$this->active_milestone = new RemediaMilestone($milestone_id);
		} // if

		if($this->active_milestone && $this->active_milestone instanceof Milestone) {
			if (!$this->active_milestone->isAccessible()) {
				$this->response->notFound();
			} // if
		}else{
			$this->response->notFound();
		}
		
		if($this->object_tracking_delegate instanceof ObjectTrackingController) {
			$this->object_tracking_delegate->__setProperties(array(
					'active_project' => &$this->active_project,
					'active_tracking_object' => &$this->active_milestone,
			));
		} // if
	}
	
}