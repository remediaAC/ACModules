<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

echo "ci";

$database->setQuery("SELECT * FROM #__voci");
$database->query();

echo "<pre>";
print_r($database->caricaListaOggetti());
echo "</pre>";

/*
echo "<ul>";
foreach($database->caricaListaOggetti() as $voce){
echo "<li>".$voce->nome."</li>";
}
echo "</ul>";*/

?>
