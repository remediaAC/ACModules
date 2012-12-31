<?php

function frosso_estimated_cost_handle_on_after_object_save(ApplicationObject &$object) {
	if($object instanceof Milestone && !($object instanceof RemediaMilestone)) {
		if(isset($_POST['milestone']['custom_field_1']) && $_POST['milestone']['custom_field_1'] != ''){
			$remedia_mil = new RemediaMilestone($object->getId());
			$remedia_mil->customFields()->setValue('custom_field_1', $_POST['milestone']['custom_field_1']);
			$remedia_mil->setNew(false);
			$remedia_mil->save();
		}
	}
}