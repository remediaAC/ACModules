<?php

//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

/*
$album puo' essere un oggetto album
oppure $idAlbum e' l'id dell'album da renderizzare
*/

function albumRender($album){
	$copertinaDefault = "http://illustriousworks.ie/files/white_label.gif";
	$album->copertina = trim($album->copertina);
	$album->copertina = $album->copertina ? $album->copertina : $copertinaDefault;
	echo "<div class=\"album\">";
	echo "<strong><a href=\"?option=com_catalogo&task=album&id=".$album->idAlbum."\">";
	echo "<div class=\"album-cover\">";
	echo "<img class=\"cover\" width=\"126\" src=\"$album->copertina\" />";
	echo "<span class=\"cover-case\"/>";
	echo "</div><span>$album->nomeAlbum</span>";
	echo "</a></strong>";
	echo "<br />";
	echo "<a href=\"?option=com_catalogo&task=artista&id=$album->idArtista\" class=\"artista\">$album->nomeArtista</a>";
	echo "<div class=\"copy\">";
	echo "<p>";
	echo "Rilasciato nel $album->annoPubblicazione";
	echo "</p>";
	echo "<p>";
	echo "Numero tracce: ".($album->numTracce?$album->numTracce:"sconosiuto");
	echo "</p>";
	echo "<p>";
	echo "Durata: ". ($album->durataTot?$album->durataTot:"sconosciuta");
	echo "</p>";
	echo "</div>";
	echo "</div>";
}

function getAlbumInfo($idAlbum, $all=false, $inizio=0, $fine=1){

	global $database,$p;

	if($all){
	$database->setQuery("SELECT ar.idArtista, ar.nomeArtista, ar.biografiaArtista, ar.fotoArtista, al.idAlbum, al.nomeAlbum, al.annoPubblicazione, nTr.numTracce, nTr.durataTot, al.copertina FROM #__album al NATURAL JOIN #__artisti ar LEFT JOIN (SELECT COUNT(*) as numTracce, sec_to_time(sum(time_to_sec(durata))) as durataTot, idAlbum FROM #__tracce GROUP BY idAlbum) nTr ON nTr.idAlbum=al.idAlbum LIMIT ".$inizio.",".$fine);
	$database->query();
	return $database->caricaListaOggetti();
	}

debug("Recupero album n. ".$idAlbum);
	$database->setQuery("SELECT ar.idArtista, ar.nomeArtista, ar.biografiaArtista, ar.fotoArtista, al.idAlbum, al.nomeAlbum, al.annoPubblicazione, nTr.numTracce, nTr.durataTot, al.copertina FROM #__album al NATURAL JOIN #__artisti ar LEFT JOIN (SELECT COUNT(*) as numTracce, sec_to_time(sum(time_to_sec(durata))) as durataTot, idAlbum FROM #__tracce GROUP BY idAlbum) nTr ON nTr.idAlbum=al.idAlbum WHERE al.idAlbum=".$idAlbum);
	$database->query();
	return $database->caricaListaOggetti(true);

}

$task = getParametri($_GET,'task');

switch ($task) {

case 'artista':

echo "<div class=\"infoArtista\">";
$idArtista = getParametri($_GET, 'id', '0');
$q="SELECT ar.nomeArtista,ar.idArtista,ar.biografiaArtista,ar.fotoArtista,nAl.numAlbum FROM #__artisti ar LEFT JOIN (SELECT al.idArtista, count(*) as numAlbum FROM #__album al GROUP BY al.idArtista) nAl ON nAl.idArtista=ar.idArtista WHERE ar.idArtista=".$idArtista;
$database->setQuery($q);
$database->query();

if(!$database->getNumRighe()) linkMancante("Nessun artista trovato");

$artista = $database->caricaListaOggetti(true);
$pagina->setTitolo("Informazioni per: ".$artista->nomeArtista);
if($artista->fotoArtista){
echo "<div id=\"fotoArtista\" style=\"float:right;margin:5px;\"><img src=\"$artista->fotoArtista\" /></div>";
}
echo "<h2>$artista->nomeArtista</h2>";
echo "<div class=\"statArtista\">";
echo "<p>Numero di album: ";
echo ($artista->numAlbum)?$artista->numAlbum:"sconosciuto";
echo "</p>";
echo "</div>";
echo "<h3>Biografia:</h3>";
echo "<div class=\"biografiaArtista\">";
echo htmlspecialchars_decode($artista->biografiaArtista);
echo "</div>";
echo "<h3>Album di questo artista:</h3>";
$database->setQuery("SELECT idAlbum FROM #__album WHERE idArtista=".$artista->idArtista." LIMIT 0,6");
$database->query();
if($database->getNumRighe()){
echo "<ul class=\"albums\">";
foreach($database->caricaListaOggetti() as $album){
$idAlbum=$album->idAlbum;
$album=getAlbumInfo($idAlbum);
$evenOdd = ( 'odd' != $evenOdd ) ? 'odd' : 'even';
echo "<li class=\"$evenOdd\">";
albumrender($album);
echo "</li>\n";
}
echo "</ul>";
}else{
echo "<p>Nessun album trovato</p>";
}
echo "</div>";
break;

case 'album':

$albumId = getParametri($_GET, 'id', false);
if($albumId){
	$albumInfo=getAlbumInfo($albumId);

	if(!$albumInfo) linkMancante("Nessun album trovato");

$pagina->setTitolo("Informazioni per l'album: ".$albumInfo->nomeAlbum);
echo "<div class=\"albumInfo\">";
echo "<div class=\"album-cover\" style=\"margin:0px 10px 0px 0px;\">";
echo "<img class=\"cover\" width=\"126\" src=\"$albumInfo->copertina\" />";
echo "<span class=\"cover-case\"/>";
echo "</div>";//album-cover
echo "<div class=\"infoAlbum\">";
echo "<h3><a href=\"?option=com_catalogo&task=artista&id=$albumInfo->idArtista\">$albumInfo->nomeArtista</a>";
echo "<br />$albumInfo->nomeAlbum</h3>";
echo "<div class=\"copy\">";
echo "<p>";
echo "Rilasciato nel $albumInfo->annoPubblicazione";
echo "</p>";
echo "<p>";
echo "Numero tracce: ".($albumInfo->numTracce?$albumInfo->numTracce:"sconosiuto");
echo "</p>";
echo "<p>";
echo "Durata totale: ". ($albumInfo->durataTot?$albumInfo->durataTot:"sconosciuta");
echo "</p>";
echo "</div>";
echo "</div>";
echo "</div>";

$database->setQuery("SELECT * FROM #__tracce WHERE idAlbum=".$albumInfo->idAlbum." ORDER BY ordine");
$database->query();

echo "<div class=\"tracceAlbum\">";
echo "<h3>Elenco dei brani:</h3>";
if($database->getNumRighe()){
echo "<table width=\"100%\">";
echo "<thead>";
echo "<td class=\"ordine\"></td>";
echo "<td class=\"titolo\">Titolo</td>";
echo "<td class=\"durata\">Durata</td>";
echo "</thead>";
echo "<tbody>";

foreach($database->caricaListaOggetti() as $traccia){
echo "<tr>";
echo "<td class=\"ordine\">$traccia->ordine</td>";
echo "<td class=\"titolo\">$traccia->nomeTraccia</td>";
echo "<td class=\"durata\">$traccia->durata</td>";
echo "</tr>";
}

echo "</tbody>";
echo "</table>";
}else{ 
echo "<p>Elenco brani sconosciuto</p>";
}
echo "</div>";
	break;
}

case 'albums':

$limite=getParametri($_REQUEST, 'limite',5);
$inizio=getParametri($_REQUEST, 'inizio',0);

$pagina->setTitolo("Visualizzazione album");
echo "<ul class=\"albums\">";
foreach(getAlbumInfo(0,true,$inizio,$limite) as $album){
$evenOdd = ( 'odd' != $evenOdd ) ? 'odd' : 'even';
echo "<li class=\"$evenOdd\">";
albumrender($album);
echo "</li>\n";
}
echo "</ul>";

//inizio codice per paginazione
$database->setQuery("SELECT * FROM #__album");
$database->query;
$p=new paginazione($database->getNumRighe(),$inizio,$limite);
$p->renderizza();

break;

default: 
$pagina->setTitolo("Elenco completo artisti");
$q="SELECT ar.nomeArtista,ar.idArtista,ar.biografiaArtista,ar.fotoArtista,nAl.numAlbum FROM #__artisti ar LEFT JOIN (SELECT al.idArtista, count(*) as numAlbum FROM #__album al GROUP BY al.idArtista) nAl ON nAl.idArtista=ar.idArtista";
$database->setQuery($q);
$database->query();

echo "<table><thead><tr><td>Nome</td><td>Numero Album</td></tr></thead><tbody>";
foreach ($database->caricaListaOggetti() as $artista){
echo "<tr>";
echo "<td><a href=\"?option=com_catalogo&task=artista&id=$artista->idArtista\" class=\"artista\">$artista->nomeArtista</a></td>";
echo "<td>";
echo ($artista->numAlbum)?$artista->numAlbum:"sconosciuto";
echo "</td>";
echo "</tr>";
}
echo "</tbody></table>";

break;


}

?>
