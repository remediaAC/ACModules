<?php

// We need projects controller
AngieApplication::useController('milestone_tasks', TASKS_MODULE);

class FrossoMilestoneTaskAssigneeController extends MilestoneTasksController{
		
	/**
	 * Active module
	 *
	 * @var string
	 */
	protected $active_module = FROSSO_MTA_MODULE;
	
	/**
	 * construct Controller
	 */
	function __construct($parent, $context = null) {
		parent::__construct($parent, $context);
	}
	
	/**
	 * Prepare controller
	 */
	function __before() {
		parent::__before();
	}
	
	function index() {
		
		parent::index();
		
		if($this->request->isWebBrowser()) {
			$milestone_tasks_per_page = 30;
		
			$this->response->assign('more_results_url', Router::assemble('milestone_tasks', array(
					'project_slug' => $this->active_project->getSlug(),
					'milestone_id' =>$this->active_milestone->getId())
			));
		
			if($this->request->get('paged_list')) {
				
				$exclude = $this->request->get('paged_list_exclude') ? explode(',', $this->request->get('paged_list_exclude')) : null;
				$timestamp = $this->request->get('paged_list_timestamp') ? (integer) $this->request->get('paged_list_timestamp') : null;
				$result = DB::execute("SELECT * FROM " . TABLE_PREFIX . "project_objects WHERE milestone_id = ? AND type = 'Task' AND state >= ? AND visibility >= ? AND id NOT IN (?) AND created_on < ? ORDER BY " . Tasks::ORDER_ANY . " LIMIT $milestone_tasks_per_page", $this->active_milestone->getId(), STATE_VISIBLE, $this->logged_user->getMinVisibility(), $exclude, date(DATETIME_MYSQL, $timestamp));
				$this->response->respondWithData(FrossoController::getDescribedTaskArray($result, $this->active_project, $this->logged_user, $milestone_tasks_per_page));
			} else {
				
				$result = DB::execute("SELECT * FROM " . TABLE_PREFIX . "project_objects WHERE milestone_id = ? AND type = 'Task' AND state >= ? AND visibility >= ? ORDER BY " . Tasks::ORDER_ANY, $this->active_milestone->getId(), STATE_VISIBLE, $this->logged_user->getMinVisibility());
				$tasks = FrossoController::getDescribedTaskArray($result, $this->active_project, $this->logged_user, $milestone_tasks_per_page);
				
				$this->response->assign(array(
						'tasks' => $tasks,
						'milestone_tasks_per_page'  => $milestone_tasks_per_page,
						'total_items' => ($result instanceof DBResult) ? $result->count() : 0,
						'milestone_id' => $this->active_milestone->getId()
				));
			} //if
		}
				
	}
	
	/**
	 * Funzione per ritornare il task array con delle informazioni in più
	 */
	private static function getDescribedTaskArray(DBResult $result, Project $active_project, User $logged_user, $items_limit = null){
		$return_value = Tasks::getDescribedTaskArray($result, $active_project, $logged_user, $items_limit);
		
		// a new array is created
		$nuovo_ritorno = array();
		
		if ($result instanceof DBResult) {
			
			$id_assegnatari = array();
			foreach($result as $row) {
				if ($row['assignee_id'] && !in_array($row['assignee_id'], $id_assegnatari)) {
					$id_assegnatari[] = $row['assignee_id'];
				} //if
			}
			
			$assegnatari_array = count($id_assegnatari) ? Users::findByIds($id_assegnatari)->toArrayIndexedBy('getId') : array();
			
			// Referenza &, non c'è copia.
			// Per ognuno aggiungo l'assignee e la data di aggiornamento
			foreach ( $return_value as $chiave => &$task ){
				foreach($result as $row) {

					//copio i vecchi valori
					foreach ($task as $k=>$v){
						$nuovo_ritorno[$chiave][$k] = $v;
					}
					
					//scorro tutto l'array dei risultati per ottenere la riga con il risultato corretto
					if($row['id'] == $task['id']){
						$nuovo_ritorno[$chiave]['assignee_id'] = $row['assignee_id'] ? $assegnatari_array[$row['assignee_id']] : null;
						$nuovo_ritorno[$chiave]['updated_on'] = $row['updated_on'] ? datetimeval($row['updated_on']) : $row['created_on'];
						
					}
				}
			}
			
		}// if
		
		return $nuovo_ritorno;
		
	}

}