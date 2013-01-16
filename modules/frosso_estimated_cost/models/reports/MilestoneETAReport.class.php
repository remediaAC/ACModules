<?php

class MilestoneETAReport {

	private $serie_array = array();
	
	private $milestones = array();
	
	/**
	 * @var Project
	 */
	private $project;

	/**
	 * Init data
	 * @param Project $project
	 */
	function __construct(Project $project) {
		$this->project = $project;
	} // __construct

	/**
	 * Renders the chart
	 * @param IUser $logged_user
	 * @return string
	 */
	function render(IUser $logged_user) {
		$db_result = DB::execute("SELECT milestone_id, COUNT(*) as count FROM ".TABLE_PREFIX."project_objects WHERE project_id = ? AND type='Task' AND state >= ? AND visibility >= ? GROUP BY milestone_id", $this->project->getId(), STATE_VISIBLE, $logged_user->getMinVisibility());
		$array_result = $db_result instanceof DBResult ? $db_result->toArrayIndexedBy('milestone_id') : false;

		if (is_foreachable($array_result)) {
			$pie_chart = new PieChart('400px', '400px', 'milestone_eta_report_pie_chart_placeholder');
			$this->serie_array = array();
			$this->milestones = array();

			// Set data for the rest
			foreach ($array_result as $serie_data) {
				$point = new ChartPoint('1', $serie_data['count']);
				$serie = new ChartSerie($point);
				if (intval($serie_data['milestone_id'])) {
					$milestone = new RemediaMilestone(intval($serie_data['milestone_id']));
					$label = PieChart::makeShortForPieChart($milestone->getName());
					$this->milestones[] = $milestone;
				} else {
					$label = lang('No Milestone');
				} //if
				$serie->setOption('label', $label);

				$this->serie_array[] = $serie;
			} //foreach

			$pie_chart->addSeries($this->serie_array);
			return $pie_chart->render();
		} else {
			return '<p class="empty_slate">' . lang('There are no milestones in this project.') . '</p>';
		} //if
	}
	
	function getMilestones() {
		return $this->milestones;
	}

}