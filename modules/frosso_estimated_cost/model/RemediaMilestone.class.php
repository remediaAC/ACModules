<?php

class RemediaMilestone extends Milestone implements ICustomFields {
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
}