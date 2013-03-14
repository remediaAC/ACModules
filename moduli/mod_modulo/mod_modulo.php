<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );
global $sessione;
echo "<ul>";
echo "<li><a href=\"?option=com_catalogo\">Catalogo</a>";
echo "<ul>";
echo "<li><a href=\"?option=com_catalogo&task=albums\">Catalogo - visualizzazione per album</a></li>";
echo "</ul>";
echo "</li>";
if($sessione->idGruppo<1) echo"<li><a href=\"?option=com_registrazione\">Registrazione</a></li>";
if($sessione->idGruppo==2) echo "<li><a href=\"?option=com_inserimento\">Inserimento</a></li>";
echo "</ul>";

?>
