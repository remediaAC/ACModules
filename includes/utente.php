<?php
//http://www.evolt.org/PHP-Login-System-with-Admin-Features
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

class utente{
	//controlla che l'username dato sia nel database
	//in caso di successo ritorna 0
	function confermaUtente($username, $userId){
		global $database;
		//aggiunge gli slash per la query
		if(!get_magic_quotes_gpc()){
			$username=addslashes($username);
		}

		//verifica che l'utente sia nel database
		$database->setQuery("SELECT id FROM #__utenti WHERE username =\"".$username."\"");
		$result = $database->query();
		if($database->getNumRighe($result)<1){
			debug("funzione confermaUtente(), fail nell'username","error");
			return 1; //indica fail nell'username
		}

		$risultato=$database->caricaListaOggetti();
		$risultato[0]->id=stripslashes($risultato[0]->id);
		$userId=stripslashes($userId);

		//controlla se l'userId e' quello corretto
		if($userId == $risultato[0]->id){
			debug("funzione confermaUtente(), successo, username e userId ok");
			return 0; //successo! username e userId confermati
		}else{
			debug("funzione confermaUtente(), userid non valido","error");
			return 2; //indica userId non valido
		}
	}

	//ritorna un array, risultato della query SQL
	function getUserInfo($username){
		global $database;
		debug("recupero informazioni per ".$username);
		$database->setQuery("SELECT * FROM #__utenti WHERE username=\"".$username."\"");
		$result = $database->query();
		if($database->getNumRighe($result)<1){
			return NULL;
		}
		$ris=$database->caricaListaOggetti();
		return $ris[0];
	}

	/*
	controlla che l'username sia nel database, dopodiche' controlla se la password e' corretta
	Se l'utente non esiste o se la password non coincide, ritorna errore.
	Se ha successo ritorna 0
	*/
	function confermaLogin($username, $password){
		debug("Funzione confermaLogin()");
		global $database;
		/* Add slashes if necessary (for query) */
		if(!get_magic_quotes_gpc()) {
			$username = addslashes($username);
		}

		/* Verify that user is in database */
		$q = "SELECT password FROM #__utenti WHERE username=\"".$username."\"";
		$database->setQuery($q);
		$result = $database->query();
		if(!$result || ($database->getNumRighe($result) < 1)){
			return 1; //Indica fail nell'username
		}

		/* Retrieve password from result, strip slashes */
		$result = $database->caricaListaOggetti(true);
		$result->password = stripslashes($result->password);
		$password = stripslashes($password);

		/* Validate that password is correct */
		if($password == $result->password){ //TODO: Aggiungere md5()
			return 0; //Successo! Username e password confermati
		}else{
			return 2; //Indica fail nella password
		}
	}

}

?>
