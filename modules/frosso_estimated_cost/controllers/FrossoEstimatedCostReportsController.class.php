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

	function set_percent() {
		if($this->request->isAsyncCall() || $this->request->isSubmitted()){
			$milestone_id	= $this->request->get('milestone_id', -1);
			$milestone 		= new RemediaMilestone($milestone_id);
			if($milestone){
				if($this->request->isSubmitted()){
					$percent = $this->request->post('percent', -1);
					if($percent >= 0 && $percent <= 100){
						$milestone->setPercentDone($percent);
						$milestone->save();
						$this->response->respondWithData($milestone, array(
								'as' => 'milestone',
								'detailed' => true
						));
					}else{
						$this->response->exception(new ValidationErrors(array(
								'percent' => lang("Value must be between 0 and 100"),
						)));
					}
				}
				$this->smarty->assign(array(
						'milestone' 	=> $milestone,
						'form_action'	=> Router::assemble('frosso_ec_set_milestone_percent', array('project_slug' => $this->request->get('project_slug'), 'milestone_id' => $milestone_id))
				));
			}else{
				$this->response->notFound();
			}
		}else{
			$this->response->badRequest("");
		}

	}


}