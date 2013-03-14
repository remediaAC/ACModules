<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

global $sessione;

if(!$sessione->loggato){
echo "<p>Loggato: ".$sessione->loggato."</p>";
echo "<p>Livello: ".$sessione->idGruppo."</p>";
echo "<p>Sessione: ".session_id()."</p>";
echo "<h3>Ciao sess.".$sessione->username." ser.".$_SERVER['PHP_AUTH_USER']."</h3>";
echo "<p><a href=\"?action=login\">Login</a></p>";
}else{
echo "<p>Loggato: ".$sessione->loggato."</p>";
echo "<p>Livello: ".$sessione->idGruppo."</p>";
echo "<p>Sessione: ".session_id()."</p>";
echo "<h3>Ciao sess.".$sessione->username." ser.".$_SERVER['PHP_AUTH_USER']."</h3>";
echo "<a href=\"?action=logout\">Effettua logout</a>";
}

?>
