<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

echo "<h1>".$conf->nomeSito."</h1>";

$database->setQuery("SELECT * FROM #__contenuti LIMIT 1");
$database->query();
$contenuto=$database->caricaListaOggetti();
echo $contenuto[0]->intro_testo;

/*
if($sessione->login('frosso','frosso')) 
echo "vero"; 
else 
echo "falso";
*/

?>
