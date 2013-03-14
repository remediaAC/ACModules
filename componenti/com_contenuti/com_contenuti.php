<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

$database->setQuery("SELECT * FROM #__contenuti WHERE id=".$Itemid." LIMIT 1");
$database->query();
$contenuto=$database->caricaListaOggetti();
echo $contenuto[0]->intro_testo;

?>
