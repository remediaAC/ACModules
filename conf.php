<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

class Config{
	var $db_host='localhost';
	var $db_user='root';
	var $db_password='root';
	var $db_nomedb='frosso-PR';
	var $db_pref='mio_';
	var $pathSito = "";
	var $urlSito = "http://localhost/progetto";
	var $nomeSito = "Mio Sito";
	var $secret = "al38as234isdjkx";

	function Config(){
		$this->pathSito = realpath(".");
	}
}

?>
