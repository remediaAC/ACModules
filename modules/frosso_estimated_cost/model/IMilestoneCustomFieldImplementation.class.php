<?php

class IMilestoneCustomFieldsImplementation extends ICustomFieldsImplementation {
	/**
	 * Return value map for given field
	 *
	 * @param $field_name
	 */
	function getValueMap($field_name) {
		$map = array();
	
		if($this->object->getProject() instanceof Project) {
			$project_objects_table = TABLE_PREFIX . 'project_objects';
			$field_name = DB::escapeFieldName($field_name);
	
			$rows = DB::execute("SELECT DISTINCT $field_name AS 'value' FROM $project_objects_table WHERE project_id = ? AND type = 'Milestone' AND state >= ? ORDER BY $field_name", $this->object->getProject()->getId(), STATE_ARCHIVED);
	
			if($rows) {
				foreach($rows as $row) {
					if($row['value']) {
						$map[$row['value']] = $row['value'];
					} // if
				} // foreach
			} // if
		} // if
	
		return $map;
	} // getValueMap
	
	/**
	 * Return list of values that we can use to aid the user (offered for auto completion)
	 *
	 * @param string $field_name
	 * @return array
	 */
	function getValueAid($field_name) {
		$aid = array();
	
		if($this->object->getProject() instanceof Project) {
			$project_objects_table = TABLE_PREFIX . 'project_objects';
			$field_name = DB::escapeFieldName($field_name);
	
			$rows = DB::execute("SELECT DISTINCT $field_name AS 'value' FROM $project_objects_table WHERE project_id = ? AND type = 'Milestone' AND state >= ? ORDER BY $field_name", $this->object->getProject()->getId(), STATE_ARCHIVED);
	
			if($rows) {
				foreach($rows as $row) {
					if($row['value'] && trim($row['value'])) {
						$aid[] = trim($row['value']);
					} // if
				} // foreach
			} // if
		} // if
	
		return count($aid) ? $aid : null;
	} // getValueAid
}