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
		return $based_on_tasks ? parent::getPercentsDone() : $this->customFields()->getValue('custom_field_1');
	}
	
	function getRemainingTime() {
		
		$tempo_stimato 		= $this->tracking()->getEstimate()->getValue();
		$tempo_impiegato 	= $this->tracking()->sumTime($user);
		$completamento		= $this->customFields()->getValue('custom_field_1');
		
		if(!$completamento) return 0;
		
		return round(((float) (($tempo_impiegato) * ((float) 1-($completamento/100)))), 2);
		
		// TODO: nope
		return round((float) (($tempo_stimato/$tempo_impiegato)/100) * $completamento, 2);
	}
	
}