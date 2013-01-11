<?php

define('FROSSO_AUTH_MODULE', 'frosso_authentication');
define('FROSSO_AUTH_MODULE_PATH', CUSTOM_PATH . '/modules/' . FROSSO_AUTH_MODULE);


require_once FROSSO_AUTH_MODULE_PATH . '/models/phpseclib0.3.1/Math/BigInteger.php';
require_once FROSSO_AUTH_MODULE_PATH . '/models/phpseclib0.3.1/Crypt/Random.php';
require_once FROSSO_AUTH_MODULE_PATH . '/models/phpseclib0.3.1/Crypt/Hash.php';
require_once FROSSO_AUTH_MODULE_PATH . '/models/phpseclib0.3.1/Crypt/RSA.php';

AngieApplication::setForAutoload(array(
	'FrossoAuthModel' => FROSSO_AUTH_MODULE_PATH . '/models/FrossoAuthModel.class.php' 
));