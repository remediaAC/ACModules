<?php
//setta la variabile per prevenire intrusioni esterne
define( '_VALID_SESSION', 1 );

include_once(dirname(__FILE__).'/conf.php');

include_once(dirname(__FILE__).'/includes/database.php');

include_once(dirname(__FILE__).'/includes/funzioni.php');

include_once(dirname(__FILE__).'/includes/moduli.php');

$conf = new Config();

$database = new database($conf->db_host, $conf->db_user, $conf->db_password, $conf->db_nomedb, $conf->db_pref);

switch ($_GET['formato']){

	case: 'html':
	break;

	case 'raw':
		include_once($conf->pathSito."/componenti/default.php");
		break;

	default:
	break;
}


?>
