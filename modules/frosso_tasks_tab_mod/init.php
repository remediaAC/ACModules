<?php

define('FROSSO_TTMOD_MODULE', 'frosso_tasks_tab_mod');
define('FROSSO_TTMOD_MODULE_PATH', CUSTOM_PATH . '/modules/' . FROSSO_TTMOD_MODULE);

AngieApplication::setForAutoload(array(
'FrossoTasksTabModModel' 			=> FROSSO_TTMOD_MODULE_PATH . '/models/FrossoTasksTabModModel.class.php',
'TaskSubscribedInspectorProperty' 	=> FROSSO_TTMOD_MODULE_PATH . '/models/TaskSubscribedInspectorProperty.class.php',
));