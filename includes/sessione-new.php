<?php

//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

class sessione{

var $sid;
var $time;
var $loggato;
var $idGruppo;
var $userid;

function sessione(){
	$this->time = time();
	debug("Creazione sessione @ ".$this->time);
	$this->inizioSessione();
}

function inizioSessione(){
	session_start();
	debug("Sessione creata: ".session_id());
	$this->loggato = $_SESSION['loggato'] = $this->controllaLogin();
	if(!$this->loggato){
		debug("L'utente non e' loggato");
		$this->username = $_SESSION['username'] = "logout";
		$this->idGruppo = $_SESSION['idGruppo'] = 0;
	}else{
		debug("L'utente e' loggato");
		$this->recuperoInfo();
	}
}
//ritorna 1 in caso di errore
function controllaLogin(){

global $utente;

if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
	$username = filter_var($_SERVER['PHP_AUTH_USER'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW);
	$pwd = filter_var($_SERVER['PHP_AUTH_PW'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW);
	//TODO: Controllo con query al database
	//confermalogin con successo ritorna 0
	if (!$utente->confermaLogin($username, $pwd)) {
		return 1;
	} else {
		return 0;
	}
}
return 0;

}

function logout(){
	session_destroy();
	$_SESSION = array();
	$sname=session_name();
	if (isset($_COOKIE[$sname])) {
		setcookie($sname,'', time()-3600,'/');
	}
	debug("Logout effettuato","warning");
}

function recuperoInfo(){
	global $utente;
	$this->userInfo = $utente->getUserInfo($_SERVER['PHP_AUTH_USER']);
	$this->username = $_SESSION['username'] = $this->userInfo->username;
	$this->userid = $_SESSION['userid'] = $this->userInfo->userid;
	$this->idGruppo = $this->userInfo->idGruppo;
}

function login(){
	global $utente;

	while (!$this->controllaLogin()) {
		header('WWW-Authenticate: Basic realm="' . $session_id . '"'); 
		header('HTTP/1.1 401 Unauthorized');
		die('Autorizzazione richiesta. vai alla <a href="index.php">home</a>');
	}
	$this->recuperoInfo();
	debug("Ok, accesso effettuato per ". $this->username, 'warning');

}

}

?>
