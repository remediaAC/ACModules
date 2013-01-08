<?php

/**
 * Frosso Estimated Cost module on_object_inspector events handler
 */

/**
 * Populate object inspector
 *
 * @param IInspectorImplementation $inspector
 * @param IInspector $object
 * @param IUser $user
 * @param string $interface
 */
function frosso_estimated_cost_handle_on_object_inspector(IInspectorImplementation &$inspector, IInspector &$object, IUser &$user, $interface) {
	if ($object instanceof Milestone) {
		if(($object->assignees()->isResponsible($user))||$object->getProject()->isLeader($user)){
			$inspector->addProperty('percent_complete', lang('Percent complete'), new MilestonePercentCompleteInspectorProperty(new RemediaMilestone($object->getId())));
			if (AngieApplication::isModuleLoaded('tracking')) {
				$inspector->addProperty('milestone_estimate', lang('Estimation'), new MilestoneEstimateInspectorProperty(new RemediaMilestone($object->getId())));
			}
		}
	} // if
} // frosso_estimated_cost_handle_on_object_inspector