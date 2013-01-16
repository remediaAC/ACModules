<?php
// Build on top of reports module
AngieApplication::useController('reports', REPORTS_FRAMEWORK_INJECT_INTO);

class FrossoEstimatedCostReportsController extends ReportsController {

	/**
	 * Index action
	 */
	function index() {
		$this->response->assign(array(
				'projects' => Projects::findActiveByUser($this->logged_user)
		));
	}

}