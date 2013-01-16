<?php

define('FROSSO_EC_MODULE', 'frosso_estimated_cost');
define('FROSSO_EC_MODULE_PATH', CUSTOM_PATH . '/modules/' . FROSSO_EC_MODULE);

AngieApplication::setForAutoload(array(
	'IMilestoneTrackingImplementation'			=> FROSSO_EC_MODULE_PATH . '/models/IMilestoneTrackingImplementation.class.php',
	'IMilestoneCustomFieldsImplementation'		=> FROSSO_EC_MODULE_PATH . '/models/IMilestoneCustomFieldsImplementation.class.php',
	'RemediaMilestone'							=> FROSSO_EC_MODULE_PATH . '/models/RemediaMilestone.class.php',
	'MilestonePercentCompleteInspectorProperty'	=> FROSSO_EC_MODULE_PATH . '/models/milestone_inspector/MilestonePercentCompleteInspectorProperty.class.php',
	'MilestoneEstimateInspectorProperty'		=> FROSSO_EC_MODULE_PATH . '/models/milestone_inspector/MilestoneEstimateInspectorProperty.class.php',
	'MilestoneETAReport'						=> FROSSO_EC_MODULE_PATH . '/models/reports/MilestoneETAReport.class.php',
));