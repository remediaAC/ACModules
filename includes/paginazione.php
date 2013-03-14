<?php
define(_PN_START,"Inizio");
define(_PN_PREVIOUS,"Precedente");
define(_PN_NEXT,"Successivo");
define(_PN_END,"Fine");

class paginazione{

// numero totale di voci
var $totali=null;
//il numero del record da cui partire a stampare
var $inizio=null;
//numero di record da mostrare per pagina
var $limite=null;
//numero di link a pagine da mostrare tra i link
var $numeroPagine=10;

	function paginazione( $totali, $inizio, $limite ) {
		$this->totali = (int) $totali;
		$this->inizio = (int) max( $inizio, 0 );
		$this->limite = (int) max( $limite, 0 );
	}
	
	function getInizio(){
	?>
	<form name="paginazione" method="POST">
	<input type="hidden" name="inizio" value="<?php echo $this->inizio; ?>">
	<input type="hidden" name="limite" value="<?php echo $this->limite; ?>">
	<?php
	}
	
	function getFine(){
		echo "</form>";
	}
	
	
	function getRender(){
	$link=str_replace("&limite=".$this->limite."&inizio=".$this->inizio,"",$_SERVER['REQUEST_URI']);

	$txt = '<div class="contatorePaginatore">';
	$pagineTotali = $this->limite ? ceil( $this->totali / $this->limite ) : 0;
	$paginaCorrente = $this->limite ? ceil( ($this->inizio+1) / $this->limite ) : 1;
	$inizioLoop = (floor(($paginaCorrente-1)/$this->numeroPagine))*$this->numeroPagine+1;
	if ($inizioLoop + $this->numeroPagine - 1 < $pagineTotali) {
		$fineLoop = $inizioLoop + $this->numeroPagine - 1;
	} else {
		$fineLoop = $pagineTotali;
	}
	
	$link .= '&amp;limite='. $this->limite;

	if (!defined( '_PN_LT' ) || !defined( '_PN_RT' ) ) {
		DEFINE('_PN_LT','&lt;');
		DEFINE('_PN_RT','&gt;');
	}

	$pnSpace = '';
	if (_PN_LT || _PN_RT) $pnSpace = "&nbsp;";

	if ($paginaCorrente > 1) {
		$page = ($paginaCorrente - 2) * $this->limite;
		$txt .= '<a onclick="javascript: document.paginazione.inizio.value=0; document.paginazione.submit();return false;" href="'. ( "$link&amp;inizio=0" ) .'" class="pagenav" title="'. _PN_START .'">'. _PN_LT . _PN_LT . $pnSpace . _PN_START .'</a> ';
		$txt .= '<a onclick="javascript: document.paginazione.inizio.value='.$page.'; document.paginazione.submit();return false;" href="'. ( "$link&amp;inizio=$page" ) .'" class="pagenav" title="'. _PN_PREVIOUS .'">'. _PN_LT . $pnSpace . _PN_PREVIOUS .'</a> ';
	} else {
		$txt .= '<span class="pagenav">'. _PN_LT . _PN_LT . $pnSpace . _PN_START .'</span> ';
		$txt .= '<span class="pagenav">'. _PN_LT . $pnSpace . _PN_PREVIOUS .'</span> ';
	}

	for ($i=$inizioLoop; $i <= $fineLoop; $i++) {
		$page = ($i - 1) * $this->limite;
		if ($i == $paginaCorrente) {
			$txt .= '<span class="pagenav">'. $i .'</span> ';
		} else {
			$txt .= '<a onclick="javascript: document.paginazione.inizio.value='.$page.'; document.paginazione.submit();return false;" href="'. ( $link .'&amp;inizio='. $page ) .'" class="pagenav"><strong>'. $i .'</strong></a> ';
		}
	}

	if ($paginaCorrente < $pagineTotali) {
		$page = $paginaCorrente * $this->limite;
		$end_page = ($pagineTotali-1) * $this->limite;
		$txt .= '<a onclick="javascript: document.paginazione.inizio.value='.$page.'; document.paginazione.submit();return false;" href="'. ( $link .'&amp;inizio='. $page ) .'" class="pagenav" title="'. _PN_NEXT .'">'. _PN_NEXT . $pnSpace . _PN_RT .'</a> ';
		$txt .= '<a onclick="javascript: document.paginazione.inizio.value='.$end_page.'; document.paginazione.submit();return false;" href="'. ( $link .'&amp;inizio='. $end_page ) .'" class="pagenav" title="'. _PN_END .'">'. _PN_END . $pnSpace . _PN_RT . _PN_RT .'</a>';
	} else {
		$txt .= '<span class="pagenav">'. _PN_NEXT . $pnSpace . _PN_RT .'</span> ';
		$txt .= '<span class="pagenav">'. _PN_END . $pnSpace . _PN_RT . _PN_RT .'</span>';
	}
	
	return $txt."</div>";
	
	}
	

	/**
	* Ritorna l'HTML per il contatore delle pagine, es: Pagina 1 di x
	*/
	function getContatorePagine(){
		$txt = '<div class="contatorePagine">';
		$page = ceil( ($this->inizio + 1) / $this->limite );
		if ($this->totali > 0) {
			$this->pagineTotali = ceil( $this->totali / $this->limite );
			$txt .= "Pagina $page di $this->pagineTotali";
		}
		return $txt."</div>";
	}
	
	/**
	* Ritorna l'HTML per il contatore dei risultati, es: Risultati 1-10 di x
	*/
	function getContatoreRisultati(){
		$txt = '<div class="contatoreRisultati">';
		$from_result = $this->inizio+1;
		if ($this->inizio + $this->limite < $this->totali) {
			$to_result = $this->inizio + $this->limite;
		} else {
			$to_result = $this->totali;
		}
		if ($this->totali > 0) {
			$txt .= "Risultati $from_result - $to_result di $this->totali";
		}
		return ($to_result ? $txt : '')."</div>";
	}
	
	/**
	* Ritorna l'HTML per il selettore del limite di risultati per pagina
	*/
	function getSelettoreLimite(){
		$txt = '<div class="selettore"><label>Mostra #</label><select name="limite" onchange="javascript: document.paginazione.limite.value=this.options[selectedIndex].value; document.paginazione.submit();return false;">';
		for ($i=5; $i <= 30; $i+=5) {
			$txt .= '<option value="'.$i.'"';
			$txt .= ($i==$this->limite) ? " selected":"";
			$txt .= '>'.$i.'</option>';
		}
		$txt .= "</select></div>";
		return $txt;
	}
	
	function renderizza(){
		echo "<div class=\"clear contenitore\"><div class=\"paginazione\">";
		echo $this->getInizio();
		echo $this->getSelettoreLimite();
		echo $this->getRender();
		echo $this->getContatorePagine();
		echo $this->getContatoreRisultati();
		echo $this->getFine();
		echo "</div></div>";
	}

}


?>