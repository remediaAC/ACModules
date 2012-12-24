<?php
// Build on top of reports module
AngieApplication::useController('reports', REPORTS_FRAMEWORK_INJECT_INTO);

class FrossoTestingController extends ReportsController {

	/**
	 * Index action
	 */
	function index() {
		$mil = new RemediaMilestone(47969);

		$defJobType = JobTypes::findById(1);
		$mil->tracking()->setEstimate(2, $defJobType, "Commento", $this->logged_user);

		$mil->setFieldValue('custom_field_1', 94);
// 		echo $mil->isModifiedField('custom_field_1');
		$mil->save();

		echo Router::assemble('project_milestone_tracking', array(
				'project_slug' => 'gantt-chart-in-activecollab',
				'milestone_id' => '47969'
				));
		
// 		print_r($mil->tracking()->getEstimate());
		$this->smarty->assign(array('val'=>$mil->customfields()->getValue('custom_field_1')));

	}

}