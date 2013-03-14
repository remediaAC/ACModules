<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

class Config{
	var $db_host='basidati.studenti.math.unipd.it';
	var $db_user='frosso';
	var $db_password='quT6pVjr';
	var $db_nomedb='frosso-PR';
	var $db_pref='mio_';
	var $pathSito = "";
	var $urlSito = "http://tecnologie-web.studenti.math.unipd.it/basi-dati/~frosso/progetto";
	var $nomeSito = "Mio Sito";
	var $secret = "al38as234isdjkx";

	function Config(){
		$this->pathSito = realpath(".");
	}
}

?>
