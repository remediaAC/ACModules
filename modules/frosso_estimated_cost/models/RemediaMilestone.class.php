<?php

class RemediaMilestone extends Milestone implements ICustomFields, ITracking {

	function __construct($id = null) {
		$this->fields = array_merge($this->fields, array('custom_field_1', 'custom_field_2', 'custom_field_3'));
		parent::__construct($id);
	}

	/**
	 * Cached search helper instance
	 *
	 * @var ITaskCustomFieldsImplementation
	 */
	private $custom_fields = false;

	/**
	 * Return search heper instance
	 *
	 * @return ITaskCustomFieldsImplementation
	 */
	function customFields() {
		if($this->custom_fields === false) {
			$this->custom_fields = new IMilestoneCustomFieldsImplementation($this);
		} // if

		return $this->custom_fields;
	} // custom_fields

	/**
	 * Tracking helper
	 *
	 * @var ITrackingImplementation
	 */
	private $tracking = false;

	/**
	 * Return tracking helper instance
	 *
	 * @return ITrackingImplementation
	 */
	function tracking() {
		if($this->tracking === false) {
			if(AngieApplication::isModuleLoaded('tracking')) {
				$this->tracking = new IMilestoneTrackingImplementation($this);
			} else {
				$this->tracking = new ITrackingImplementationStub($this);
			} // if
		} // if

		return $this->tracking;
	} // tracking


	function getPercentsDone($based_on_tasks = true) {
		return $based_on_tasks ? parent::getPercentsDone() : $this->getCustomField1();
	}

	function getRemainingTime() {

		$tempo_stimato 		= $this->tracking()->getEstimate()->getValue();
		$tempo_impiegato 	= $this->tracking()->sumTime($user);
		$completamento		= $this->getCustomField1();

		if(!$completamento) return 0;

		return round(((float) (($tempo_impiegato/$completamento) * ((float) 100-($completamento)))), 2);

	}

	/**
	 * Routing context parameters
	 *
	 * @var array
	 */
	private $routing_context_params = false;

	/**
	 * Return routing context parameters
	 *
	 * @return array
	 */
	function getRoutingContextParams() {
		if($this->routing_context_params === false) {
			$this->routing_context_params = array(
					'project_slug' => $this->getProject()->getSlug(),
					'milestone_id' => $this->getId()
			);
		} // if

		return $this->routing_context_params;
	} // getRoutingContextParams

	/**
	 * Return routing context name
	 *
	 * @return string
	 */
	function getRoutingContext() {
		return 'project_milestone';
	} // getRoutingContext

	/**
	 * Return array or property => value pairs that describes this object
	 *
	 * $user is an instance of user who requested description - it's used to get
	 * only the data this user can see
	 *
	 * @param IUser $user
	 * @param boolean $detailed
	 * @param boolean $for_interface
	 * @return array
	 */
	function describe(IUser $user, $detailed = false, $for_interface = false) {
		$result = parent::describe($user, $detailed, $for_interface);

		$result['id'] = $this->getId();

		if($detailed){
			$result['custom_percent_complete'] = $this->getPercentsDone(false);
			$result['remaining_time'] = $this->getRemainingTime();
			$result['summed_time'] = $this->tracking()->sumTime(Authentication::getLoggedUser());
		}

		return $result;
	}

	function describeForApi(IUser $user, $detailed = false) {
		$result = parent::describeForApi($user, $detailed);

		$result['id'] = $this->getId();

		if($detailed){
			$result['custom_percent_complete'] = $this->getPercentsDone(false);
			$result['remaining_time'] = $this->getRemainingTime();
			$result['summed_time'] = $this->tracking()->sumTime(Authentication::getLoggedUser());
		}

		return $result;
	}

	/**
	 * Set percent completion custom field value.
	 * @param int $value 0 <= $value <= 100
	 */
	function setPercentDone($value) {
		if($value < 0 || $value > 100)
			return null;
		return $this->setCustomField1($value);
	}

	function validate($errors){
		parent::validate($errors);
		if($this->validatePresenceOf('custom_field_1')){
			if($this->getCustomField1() < 0 || $this->getCustomField1() > 100){
				$errors->addError(lang('Percent complete value must be between 0 and 100'), 'custom_field_1');
			}
		}
	}

	function save() {
		// hack
		DB::beginWork('Saving Milestone @ ' . __CLASS__);
// 		if($this->isNew()){
		DB::execute('UPDATE ' . TABLE_PREFIX . 'object_contexts SET parent_type = ? WHERE parent_id = ?', 'RemediaMilestone', $this->getId());
// 		}
		$result = parent::save();
		// hack
		DB::execute('UPDATE ' . TABLE_PREFIX . 'object_contexts SET parent_type = ? WHERE parent_id = ?', 'Milestone', $this->getId());
		DB::execute('UPDATE ' . TABLE_PREFIX . 'project_objects SET type = ? WHERE type = ?', 'Milestone', 'RemediaMilestone');
		DB::commit('Milestone saved @ ' . __CLASS__);
		
		return $result;
	}

}