<?php

define('FROSSO_MAILN_MODULE', 'frosso_mail_notify');
define('FROSSO_MAILN_MODULE_PATH', CUSTOM_PATH . '/modules/' . FROSSO_MAILN_MODULE);

AngieApplication::setForAutoload(array(
	'NotificationsActivityLogs' 			=> FROSSO_MAILN_MODULE_PATH . '/models/NotificationsActivityLogs.class.php',
));
