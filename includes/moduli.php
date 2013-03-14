<?php

//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

function initModuli(){
	global $database, $globals;
	
	$sql= "SELECT * FROM #__moduli "
	. "WHERE pubblicato = '1' "
	. "ORDER BY ordine";
	
	$database->setQuery($sql);
	
	$moduli = $database->caricaListaOggetti();
	
	foreach($moduli as $modulo){
		$modulo->parametri = dividiParametri($modulo->parametri);
		$globals['_moduli'][$modulo->posizione][] = $modulo;
	}
}

function caricaModuli($posizione='left'){
	global $globals;
	
	if(contamoduli($posizione))
		foreach($globals['_moduli'][$posizione] as $modulo){
	
			$mod = new modulo($modulo);
			$mod->render();
		
		}
}

function contaModuli($posizione='left'){
	global $globals;
	return count($globals['_moduli'][$posizione]);
}



class modulo{

var $config;

function modulo($conf){
	$this->config=$conf;
}

function getTitolo(){
		return $this->config['titolo'];
}

function getContenuto(){
	return $this->config['contenuto'];
}

function getAttributo($attributo){
	return $this->config->$attributo;
}

function render(){
	global $conf;
	global $database;
	
	echo "<div class=\"modulo modulo-" . $this->getAttributo('posizione')
	. " nome-" . $this->getAttributo('nome_modulo') ."\" "
	. " id=\"modulo-". $this->getAttributo('id') ."\">";

	
	if($this->getAttributo('mostra_titolo')!=0 && $this->getAttributo('titolo')!="<none>"){
		echo "<h3 class=\"titolo\">".$this->getAttributo('titolo')."</h3>";
	}

	echo "<div class=\"contenuto\">";
	include_once($conf->pathSito . "/moduli/".$this->getAttributo('nome_modulo')."/".$this->getAttributo('nome_modulo').".php");
	echo "</div>";

	echo "</div>";
	
}

}


?>
