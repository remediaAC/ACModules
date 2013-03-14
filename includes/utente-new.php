<?php
//http://www.evolt.org/PHP-Login-System-with-Admin-Features
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

class utente{
	//controlla che l'username dato sia nel database
	//in caso di successo ritorna 0
	function confermaUtente($username, $sid){
		global $database;
		//aggiunge gli slash per la query
		if(!get_magic_quotes_gpc()){
			$username=addslashes($username);
		}

		//verifica che l'utente sia nel database
		$database->setQuery("SELECT sid FROM #__utenti WHERE username =\"".$username."\"");
		$result = $database->query();
		if($database->getNumRighe($result)<1){
			debug("funzione confermaUtente(), fail nell'username","error");
			return 1; //indica fail nell'username
		}

		$risultato=$database->caricaListaOggetti(true);
		$risultato->id=stripslashes($risultato->id);
		$sid=stripslashes($sid);

		//controlla se l'userId e' quello corretto
		if($sid == $risultato[0]->sid){
			debug("funzione confermaUtente(), successo, username e sid ok");
			return 0; //successo! username e sid confermati
		}else{
			debug("funzione confermaUtente(), sid non valido","error");
			return 2; //indica userId non valido
		}
	}

	//ritorna un array, risultato della query SQL
	function getUserInfo($username){
		global $database;
		debug("Recupero informazioni per ".$username);
		$database->setQuery("SELECT * FROM #__utenti WHERE username=\"".$username."\"");
		$result = $database->query();
		if($database->getNumRighe()<1){
			return NULL;
		}
		return $database->caricaListaOggetti(true);
	}

	function aggiungiUtenteAttivo($username, $time){
		$q="UPDATE #__utenti SET timestamp ='$time' WHERE username=\"".$username."\"";
		$database->setQuery($q);
		$database->query();

		//TODO: Aggiungere query per tenere traccia degli utenti attivi
	}

	/*
	controlla che l'username sia nel database, dopodiche' controlla se la password e' corretta
	Se l'utente non esiste o se la password non coincide, ritorna errore.
	Se ha successo ritorna 0
	*/
	function confermaLogin($username, $password){
		global $database;
		/* Add slashes if necessary (for query) */
		if(!get_magic_quotes_gpc()) {
			$username = addslashes($username);
		}

		/* Verify that user is in database */
		$q = "SELECT password FROM #__utenti WHERE username=\"".$username."\"";
		$database->setQuery($q);
		$result = $database->query();
		if(!$result || ($database->getNumRighe() < 1)){
			debug("Funzione confermaLogin(), fail nell'username","error");
			return 1; //Indica fail nell'username
		}

		/* Recupera la password dal risultato, strip slashes */
		debug("Funzione confermaLogin(), recupero password");
		$result = $database->caricaListaOggetti(true);
		$result->password = stripslashes($result->password);
		$password = stripslashes($password);

		/* Validate that password is correct */
		if($password == $result->password){ //TODO: Aggiungere md5()
			debug("Successo! Username e password confermati");
			return 0; //Successo! Username e password confermati
		}else{
			debug("Funzione confermaLogin(), fail nella password","error");
			return 2; //Indica fail nella password
		}
	}

}

?>
