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
		$milestones_t 	= Milestones::findAllByProject($this->active_project);
		$tasks_t 		= Tasks::findByProject($this->active_project, $this->logged_user);
		$milestones 	= array();
		$tasks 			= array();
		
		// voglio il task non categorizzato che inizia prima di tutti, quindi setto questo nel futuro
		$first_task_time = new DateValue(time()+time());
		$trovato = false;
		
		if(is_foreachable($tasks_t)){
			foreach($tasks_t as $task){
				$res = array();
				
				$res['id'] 			= $task->getTaskId();
				$res['name'] 		= $task->getName();
				
				$task->complete()->describe($this->logged_user, true, true, $completion_description);
				$task_description = $task->describe($this->logged_user, true, true);
				$res['is_completed'] 	= $completion_description['is_completed'];
				$res['completed_on'] 	= $completion_description['completed_on'];
				$res['due_on']			= $completion_description['due_on']; // non è sempre settato
				
				$res['milestone_id'] 	= $task_description['milestone_id'] ? $task_description['milestone_id'] : 0;
				
				$res['created_on_d'] 	= $task->getCreatedOn()->getDay();
				$res['created_on_m'] 	= $task->getCreatedOn()->getMonth()-1;
				$res['created_on_y'] 	= $task->getCreatedOn()->getYear();
				
				// La data di inizio non è sempre presente. Quindi se non c'è, prendo la data di creazione del task. 
				// Inoltre questo campo dipende dal modulo TaskPlus
				if(AngieApplication::isModuleLoaded('tasks_plus') && TaskPlus::getStartOn($task)){
					$start_on = TaskPlus::getStartOn($task);
				}else{
					$start_on = $task->getCreatedOn();
				}
				$res['start_on_d'] 	= $start_on->getDay();
				$res['start_on_m'] 	= $start_on->getMonth()-1; //javascript merda parte da Gennaio = 0
				$res['start_on_y'] 	= $start_on->getYear();
				
				
				// giorni in più
				$days = (60 * 60 * 24) * 15; //15 giorni in più
				if($completion_description['is_completed']){
					$completion_date = $completion_description['completed_on'];
				}else if($completion_description['due_on']){ // non è completata ma ha data di fine settata
					$completion_date = $completion_description['due_on'];
				}else if(!$completion_description['due_on']){ // non è completata e non ha data di fine settata
					$completion_date = $start_on->advance($days, false); // (data_inizio || data_creazione) + 15 giorni
				}
				
				$res['finish_on_d'] 	= $completion_date->getDay();
				$res['finish_on_m'] 	= $completion_date->getMonth()-1; //javascript merda parte da Gennaio = 0
				$res['finish_on_y'] 	= $completion_date->getYear();
				
				$res['durata'] = $start_on->daysBetween($completion_date) * 8; //giorni_differenza * ore_lavorative
				
				if($res['is_completed']){
					$res['percent_completion'] = 100;
				}else{
					list($total_subtasks, $open_subtasks) = ProjectProgress::getObjectProgress($task);
					$completed_subtasks = $total_subtasks - $open_subtasks;
					if($open_subtasks) {
						$res['percent_completion'] = ceil((( ($completed_subtasks ) / $total_subtasks) * 100));
					} else {
						$res['percent_completion'] = 0;
					}
				}
				echo $res['percent_completion'].' ';
				$tasks[] = $res;
				
				if(($res['milestone_id'] == 0) &&($first_task_time->getTimestamp() > $start_on->getTimestamp())){
					$first_task_time = $start_on;
					$trovato = false;
				}
				
			}
		}
		
		if($trovato){
			//Aggiungo la milestone per tasks non categorizzati
			$milestones[0]['id'] 			= 0;
			$milestones[0]['name'] 			= lang("Uncategorized");
			$milestones[0]['start_on_d'] 	= $first_task_time->getDay();
			$milestones[0]['start_on_m'] 	= $first_task_time->getMonth()-1;
			$milestones[0]['start_on_y'] 	= $first_task_time->getYear();
			$milestones[0]['durata'] 		= 1;
		}
		
		if(is_foreachable($milestones_t)){
			foreach($milestones_t as $milestone){
				$res = array();
				
				$res['id']	 		= $milestone->getId();
				$res['name'] 		= $milestone->getName();
				$res['start_on_d'] 	= $milestone->getStartOn()->getDay();
				$res['start_on_m'] 	= $milestone->getStartOn()->getMonth()-1; //javascript merda parte da Gennaio = 0
				$res['start_on_y'] 	= $milestone->getStartOn()->getYear(); 
				$res['durata']		= (($milestone->getDueOn()->getTimestamp() - $milestone->getStartOn()->getTimestamp()) / (60 * 60 * 24)) * 8; //giorni * ore lavorative
				
				$milestones[] = $res;
			}
		}
		$this->smarty->assign(array(
				'milestones' 	=> $milestones,
				'tasks'			=> $tasks
				)
				);
	}
	
}