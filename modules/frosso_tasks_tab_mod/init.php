<?php

define('FROSSO_TTMOD_MODULE', 'frosso_tasks_tab_mod');
define('FROSSO_TTMOD_MODULE_PATH', CUSTOM_PATH . '/modules/' . FROSSO_TTMOD_MODULE);

AngieApplication::setForAutoload(array(
'FrossoModel' => FROSSO_TTMOD_MODULE_PATH . '/models/FrossoModel.class.php',
));