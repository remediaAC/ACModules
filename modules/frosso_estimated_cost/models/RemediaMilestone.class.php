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
	
}