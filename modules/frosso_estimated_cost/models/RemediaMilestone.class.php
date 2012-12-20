<?php

class RemediaMilestone extends Milestone implements ICustomFields, ITracking {
	
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
				$this->tracking = new ITrackingImplementation($this);
			} else {
				$this->tracking = new ITrackingImplementationStub($this);
			} // if
		} // if
	
		return $this->tracking;
	} // tracking
	
}