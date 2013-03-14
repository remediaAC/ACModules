<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

global $sessione;

if($sessione->idGruppo!=2) $pagina->linkMancante();

$errorePresente=false;
$errori=array();
$task = getParametri($_REQUEST, 'task');

switch($task){

case 'artista':
$pagina->setTitolo("Pagina per l'inserimento di un artista");
//recupero parametri
$allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
$allowedTags.='<li><ol><ul><span><div><br><ins><del><a>';
$nomeArtista=trim(getParametri($_POST,'nomeArtista'));
$biografiaArtista=htmlspecialchars(strip_tags(stripslashes(getParametri($_POST,'biografiaArtista',null,2)), $allowedTags));
$fotoArtista=trim(getParametri($_POST,'fotoArtista'));
if(getParametri($_POST,'inserimento',false)){
$q = "INSERT INTO #__artisti (`idArtista` , `nomeArtista` , `biografiaArtista` , `fotoArtista`)"
. " VALUES ( NULL, \"$nomeArtista\", \"$biografiaArtista\", \"$fotoArtista\")";
$database->setQuery($q);
print(htmlspecialchars_decode($biografiaArtista));
if(!$database->query()){
$errorePresente=true;
$pagina->setMessaggio("Errore nella query. Riprovare in un secondo momento.","errore");
}
}
?>

<form name="inserimentoArtista" method="post" action="index.php" >
<input type="hidden" value="com_inserimento" name="option">
<input type="hidden" value="artista" name="task">
<input type="hidden" value="true" name="inserimento">
Nome Artista: <input type="text" name="nomeArtista" length="40" value="<?php echo $nomeArtista; ?>">
<br />
Biografia Artista: 
<br />
<textarea rows="8" cols="50" name="biografiaArtista">
<?php echo $biografiaArtista; ?>
</textarea>
<br />
<span class="descrizioneCampo" style="font-size:11px;">Sono ammessi tag html</span>
<br />
Foto Artista: <input type="text" name="fotoArtista" value="<?php echo $fotoArtista; ?>">
<br />
<span class="descrizioneCampo" style="font-size:11px;">Puoi inserire l'immagine residente in un altro server web</span>
<br />
<input type="submit" value="Invia" />
</form>

<?php
break;

case 'traccia':
$pagina->setTitolo("Pagina per l'inserimento di una traccia");

//recupero parametri
$idAlbum=trim(getParametri($_POST,'idAlbum'));
$nomeTraccia=trim(getParametri($_POST,'nomeTraccia'));
$numeroTraccia=trim(getParametri($_POST,'numeroTraccia',0));
$durata=trim(getParametri($_POST,'durata'));
if(getParametri($_POST,'inserimento',false)){
if($numeroTraccia==0){
$database->setQuery("SELECT MAX(ordine) AS max FROM #__tracce WHERE idAlbum=\"$idAlbum\"");
$database->query();
$ordine=$database->caricaListaOggetti(true);
$numeroTraccia=($ordine->max)+1;
}
$q = "INSERT INTO #__tracce (`idTraccia` , `nomeTraccia` , `durata` , `idAlbum`, `ordine`)"
. " VALUES ( NULL, \"$nomeTraccia\", \"$durata\", \"$idAlbum\", \"$numeroTraccia\")";
$database->setQuery($q);
if(!$database->query()){
$errorePresente=true;
$pagina->setMessaggio("Errore nella query. Riprovare in un secondo momento.","errore");
$numeroTraccia--;
}
if(!$errorePresente)$pagina->setMessaggio("Inserimento completato con successo");
}

?>

<form name="inserimentoTraccia" method="post" action="index.php" >
<input type="hidden" value="com_inserimento" name="option">
<input type="hidden" value="traccia" name="task">
<input type="hidden" value="true" name="inserimento">
<label>Nome Traccia: </label><input type="text" name="nomeTraccia" length="40" value="<?php echo $nomeTraccia; ?>">
<br />
<label>Numero Traccia: </label><input type="text" name="numeroTraccia" length="3" value="<?php echo $numeroTraccia; ?>">
<span class="descrizioneCampo" style="font-size:11px;">Lasciare vuoto o 0 per tentare di incrementare automaticamente</span>
<br />
<label>Durata Traccia: </label><input type="text" name="durata" length="3" value="<?php echo $durata; ?>">
<span class="descrizioneCampo" style="font-size:11px;">Inserire nel formato hh:mm:ss</span>
<br />
<label>Album di Appartenenza: </label><select name="idAlbum" size="1">
<?php

$database->setQuery("SELECT * FROM #__album al NATURAL JOIN #__artisti ar ORDER BY ar.nomeArtista,al.nomeAlbum");
$database->query();
foreach($database->caricaListaOggetti() as $album){
echo "<option value=\"".$album->idAlbum."\"";
if($album->idAlbum==$idAlbum){echo " selected";}
echo ">";
echo $album->nomeArtista." - ".$album->nomeAlbum;
echo "</option>\n";
}

?>
</select>

<input type="submit" value="Invia" />
</form>

<?php
break;

case 'album':
$pagina->setTitolo("Pagina per l'inserimento di un album");
//recupero parametri
$nomeAlbum=trim(getParametri($_POST,'nomeAlbum'));
$copertinaAlbum=trim(getParametri($_POST,'copertinaAlbum'));
$annoPubblicazione=trim(getParametri($_POST,'annoPubblicazione'));
$idArtista=trim(getParametri($_POST,'idArtista'));
$prezzo=trim(getParametri($_POST,'prezzo'));
if(getParametri($_POST,'inserimento',false)){
$q = "INSERT INTO #__album (`idAlbum` , `nomeAlbum` , `annoPubblicazione` , `copertina` , `idArtista` , `prezzo`)"
. " VALUES ( NULL, \"$nomeAlbum\", \"$annoPubblicazione\", \"$copertina\", \"$idArtista\", \"$prezzo\")";
$database->setQuery($q);
if(!$database->query()){
$errorePresente=true;
$pagina->setMessaggio("Errore nella query. Riprovare in un secondo momento.","errore");
}
if(!$errorePresente)$pagina->setMessaggio("Inserimento completato con successo");
}
?>

<form name="inserimentoAlbum" method="post" action="index.php" >
<input type="hidden" value="com_inserimento" name="option">
<input type="hidden" value="album" name="task">
<input type="hidden" value="true" name="inserimento">
Nome Album: <input type="text" name="nomeAlbum" length="40" value="<?php echo $nomeAlbum; ?>">
<br />
Copertina Album: <input type="text" name="copertinaAlbum" value="<?php echo $copertinaAlbum; ?>">
<br />
<span class="descrizioneCampo" style="font-size:11px;">Puoi inserire l'immagine residente in un altro server web</span>
<br />
Anno di Pubblicazione: <input type="text" name="annoPubblicazione" value="<?php echo $annoPubblicazione; ?>">
<br />
<label>Artista dell'Album: </label><select name="idArtista" size="1">
<?php

$database->setQuery("SELECT * FROM #__artisti ar ORDER BY ar.nomeArtista");
$database->query();
foreach($database->caricaListaOggetti() as $artista){
echo "<option value=\"".$artista->idArtista."\"";
if($artista->idArtista==$idArtista){echo " selected";}
echo ">";
echo $artista->nomeArtista;
echo "</option>\n";
}

?>
</select>
<input type="submit" value="Invia" />
</form>
<?php

if(!($errorePresente)&&(getParametri($_POST,'inserimento',false))){
$msg="Inserimento effettuato con successo. Puoi andare ora alla ";
$msg.="<a href=\"?option=com_inserimento&task=traccia\">";
$msg.="pagina di inserimento tracce";
$msg.="</a>";
$pagina->setMessaggio($msg);
}

break;

default: 
$pagina->setTitolo("Pagina per l'inserimento dei contenuti");
?>
<form name="selezioneOperazione" method="get">
<input type="hidden" value="com_inserimento" name="option">
Seleziona l'azione: 
<select name="task" size="1">
  <option value="artista">Inserimento Artista</option>
  <option value="album">Inserimento Album</option>
  <option value="traccia">Inserimento Traccia</option>
</select>
<input type="submit" value="Invia" />
</form>
<?php

break;

}

?>
