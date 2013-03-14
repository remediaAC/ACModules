<?php

//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

class sessione{

	var $time;
	var $username;
	var $userid;
	var $userinfo;
	var $idGruppo;
	var $loggato;
	var $referrer;
	var $url;

function __construct(){
	$this->time = time();
	$this->loggato=0;
	debug("Creazione sessione @ ".$this->time);
	$this->inizioSessione();
}

function inizioSessione(){
	global $database, $utente;
	session_start();

	$this->loggato = $this->controllaLogin();
	if(!$this->loggato){
		$this->username = $_SESSION['username'] = 'guest';
		$this->livelloUtente = 0;
		//TODO: controllare livello utenti
		//TODO: se si vuole tenere traccia degli utenti guest, fare qui una query che aggiunge un utente guest
		//$database->setQuery("");
	}else{
		//TODO: Query per aggiornare tabella degli utenti attivi inserendo utente corrente
		//$user->aggiungiUtenteAttivo($this->username, $this->time);
	}

	//TODO: query per aggiornare tabella utenti inattivi (rimuovendoli)
	//TODO: query per aggiornare tabella ospiti inattivi (rimuovendoli)

	//set pagina referrer
	if(isset($_SESSION['url'])){
		$this->referrer = $_SESSION['url'];
	}else{
		$this->referrer = "/";
	}

	/* Set current url */
	$this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
	debug("Creato utente con livello ".$this->livelloUtente,'warning');
}

//OK
//controlla se l'utente ha fatto il login precedentemente
function controllaLogin(){
	global $database, $utente;

	//controlla se l'utente e' stato ricordato
	if(isset($_COOKIE['cookie']) && isset($_COOKIE['cookieid'])){
		debug("funzione controllaLogin(), Utente ricordato");
		$this->username = $_SESSION['username'] = $_COOKIE['cookie'];
		$this->userid = $_SESSION['userid'] = $_COOKIE['cookieid'];
	}

	//nomeutente e userid sono stati settati e non e' ospite
	if(isset($_SESSION['username']) && isset($_SESSION['userid']) && $_SESSION['username'] != 'guest'){
		//conferma che username e userid sono validi
		if($utente->confermaUtente($_SESSION['username'], $_SESSION['userid']) != 0){
			debug("funzione controllaLogin(), Errore: cookie non validi", 'error');
			unset($_SESSION['username']);
			unset($_SESSION['userid']);
			return 0;
		}

		debug("Funzione controllalogin(), recupero informazioni");
		//l'utente e' loggato, setta le variabili di classe
		$this->userInfo = $utente->getUserInfo($_SESSION['username']);
		$this->username = $this->userinfo['username'];
		$this->userid = $this->userinfo['userid'];
		$this->idGruppo = $this->userinfo->idGruppo;
		debug("Ok, accesso effettuato", 'warning');
		return 1;
	}else{
		//utente non loggato
		debug("funzione controllaLogin(), Utente non loggato");
		return 0;
	}
}

function login($subuser, $subpass, $subricorda = false){
	global $database, $utente;
	$err=false;
	if(!$subuser || strlen($subuser = trim($subuser)) == 0){
	//TODO: errore: username non inserito
	$err=true;
	debug("Errore: username non inserito", 'error');
	}else{
	/* Check if username is not alphanumeric */
	if(!eregi("^([0-9a-z])*$", $subuser)){
	//TODO: errore: username non alfanumerico
	debug("Errore: username non alfanumerico", 'error');
	$err=true;
	}
	}

	/* Password error checking */
	if(!$subpass){
	//TODO: errore: password non inserita
	$err=true;
	debug("Errore: password non inserita", 'error');
	}

	/* Return if form errors exist */
	if($err){
	return false;
	}

	/* Checks that username is in database and password is correct */
	$subuser = stripslashes($subuser);
	$result = $utente->confermaLogin($subuser, $subpass); //TODO: Aggiungere md5()

	/* Check error codes */
	if($result == 1){
	//TODO: Errore: username non trovato
	$err=true;
	debug("Errore: username non trovato", 'error');
	}
	else if($result == 2){
	//TODO: Errore: password non valida
	debug("Errore: password non valida", 'error');
	$err=true;
	}

	/* Return if form errors exist */
	if($err){
	return false;
	}

	debug("funzione login, recupero informazioni");
	/* Username and password correct, register session variables */
	$this->userinfo  = $utente->getUserInfo($subuser);
	$this->username = $_SESSION['username'] = $this->userinfo['username'];
	$this->userid = $_SESSION['userid']   = $this->userinfo['userid'];
	$this->idGruppo = $this->userinfo->idGruppo;
	$this->loggato = 1;

	debug("Login effettuato per utente ".$this->username);

	/* Insert userid into database and update active users table */
	//$database->updateUserField($this->username, "userid", $this->userid);
	//$database->addActiveUser($this->username, $this->time);
	//$database->removeActiveGuest($_SERVER['REMOTE_ADDR']);

	/**
	* This is the cool part: the user has requested that we remember that
	* he's logged in, so we set two cookies. One to hold his username,
	* and one to hold his random value userid. It expires by the time
	* specified in constants.php. Now, next time he comes to our site, we will
	* log him in automatically, but only if he didn't log out before he left.
	*/
	if($subricorda){
		debug("OPT: Cookie 'ricorda' settato");
		$cookieExpire=60*60*24*100;  //100 giorni di default
		$cookiePath="/";
		setcookie("cookname", $this->username, time()+$cookieExpire, $cookiePath);
		setcookie("cookieid",   $this->userid,   time()+$cookieExpire, $cookiePath);
	}

	/* Login completato con successo */
	return true;
}

}

?>
