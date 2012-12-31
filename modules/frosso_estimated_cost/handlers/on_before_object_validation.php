<?php

function frosso_estimated_cost_handle_on_before_object_validation(ApplicationObject &$object) {
	if($object instanceof Milestone && !($object instanceof RemediaMilestone)) {
		if(isset($_POST['milestone']['custom_field_1']) && $_POST['milestone']['custom_field_1'] != '' && ($_POST['milestone']['custom_field_1'] < 0 || $_POST['milestone']['custom_field_1'] > 100) ) {
			throw new ValidationErrors(array('custom_field_1' => lang("Percent complete value must be between 0 and 100")));
		}
	}
}