<?php

//setta la variabile per prevenire intrusioni esterne
define( '_VALID_SESSION', 1 );

include_once(dirname(__FILE__).'/conf.php');

include_once(dirname(__FILE__).'/includes/database.php');

include_once(dirname(__FILE__).'/includes/funzioni.php');
include_once(dirname(__FILE__).'/includes/paginazione.php');

include_once(dirname(__FILE__).'/includes/moduli.php');

include_once(dirname(__FILE__).'/includes/pagina.php');

include_once(dirname(__FILE__).'/includes/sessione-new.php');
include_once(dirname(__FILE__).'/includes/utente-new.php');

$debug = array();

$conf = new Config();

$database = new database($conf->db_host, $conf->db_user, $conf->db_password, $conf->db_nomedb, $conf->db_pref);

$utente = new utente();
$sessione = new sessione();
$pagina = new pagina();

if($act = getParametri($_GET,'action',0)){
	if($act == 'login') {$sessione->login(); header("Location: $conf->urlSito/");}
	if($act == 'logout') {
		$sessione->logout();
		header("Location: http://logout:logout@".str_replace("http://","",$conf->urlSito)."/", TRUE, 301);
	}
}

/*
//$utente = new utente();
//$sessione = new sessione();


if(getParametri($_POST,'sublogin',0)){
	if($sessione->login(getParametri($_POST,'username',0),getParametri($_POST,'pass',0),getParametri($_POST,'remember',0))) {}
		//echo "vero"; 
}
*/

ob_start();
mostraContenuto();
$contenuto = ob_get_contents();
ob_end_clean();

initModuli();

include_once($pagina->getTemplatePath()."/index.php");

?>
