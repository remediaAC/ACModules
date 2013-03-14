<?php

//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );


function mostraContenuto(){

	global $database, $_GET, $conf, $pagina;
	$Itemid = getParametri($_GET, 'Itemid', '1');
	//$database->setQuery( "SELECT * FROM #__menu WHERE id = '$Itemid' LIMIT 1" );
	//$database->query();
	//$menu = $database->caricaListaOggetti();
	$componenteDaCaricare = getParametri($_REQUEST,'option', 'com_contenuti');
	//echo $menu['0']->nome;
	if(file_exists($conf->pathSito . "/componenti/" . $componenteDaCaricare . "/" . $componenteDaCaricare . ".php"))
		include_once( $conf->pathSito . "/componenti/" . $componenteDaCaricare . "/" . $componenteDaCaricare . ".php" ); 
	else
		$pagina->linkMancante();

	//caricaComponente( 'contenuti' );

}

function linkMancante($msg='Pagina non trovata'){
Header("HTTP/1.1 404 Not Found");
echo "<h1>$msg</h1>";
exit();
}

class pagina{
var $titolo;
var $templatePath;
var $templateSrc;
var $messaggi;
function pagina(){
	global $conf;
	$this->titolo="Home";
	$this->templatePath=$conf->pathSito."/templates/default";
	$this->templateSrc=$conf->urlSito."/templates/default";
}

function setTitolo($titolo){ $this->titolo=$titolo; }

function getTitolo(){return $this->titolo; }

function getTemplatePath(){ return $this->templatePath; }

function getTemplateSrc(){ return $this->templateSrc; }

function linkMancante($msg='Pagina non trovata'){ global $conf; linkMancante($msg."<br/>Torna alla <a href=\"".$conf->urlSito."\">Home</a>"); }

function setMessaggio($testo,$tipo="stato"){ $this->messaggi[$tipo][]=$testo; }

function stampaMessaggi(){
if($this->messaggi["stato"][0]){
echo "<div class=\"messaggi stato\">";
foreach($this->messaggi["stato"] as $msg){
echo "<p>".$msg."</p>";
}
echo "</div>";
}

if($this->messaggi["warning"][0]){
echo "<div class=\"messaggi warning\">";
foreach($this->messaggi["warning"] as $msg){
echo "<p>".$msg."</p>";
}
echo "</div>";
}

if($this->messaggi["errore"][0]){
echo "<div class=\"messaggi errore\">";
foreach($this->messaggi["errore"] as $msg){
echo "<p>".$msg."</p>";
}
echo "</div>";
}

}

}


?>
