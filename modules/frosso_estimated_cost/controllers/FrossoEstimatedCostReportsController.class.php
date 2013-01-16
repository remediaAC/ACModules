<?php
// Build on top of reports module
AngieApplication::useController('reports', REPORTS_FRAMEWORK_INJECT_INTO);

class FrossoEstimatedCostReportsController extends ReportsController {

	/**
	 * Prepare controller
	 */
	function __before() {
		parent::__before();

		if($this->logged_user->isProjectManager() || $this->logged_user->isPeopleManager() || $this->logged_user->isFinancialManager()) {
			$this->response->assign(array(
					'logged_user' => $this->logged_user,
			));
		} else {
			$this->response->forbidden();
		} // if
	} // __construct

	/**
	 * Index action
	 */
	function index() {
		$this->response->assign(array(
				'projects_exist' => count($this->logged_user->projects()->getIds())
		));
	}

	function form_run() {
		if ($this->request->isAsyncCall()) {
			$project = $this->request->get('project_id') ? Projects::findById($this->request->get('project_id')) : null;

			if($project instanceof Project) {
				// TODO: eliminare group_by
				$report = new MilestoneETAReport($project);

				$this->response->assign('rendered_report_result', $report->render($this->logged_user));
				$this->response->assign('milestones', $report->getMilestones());
				$this->response->assign('detailed_report', true);
			} else {
				$this->response->notFound();
			} // if
		} else {
			$this->response->badRequest();
		} //if
	}

}