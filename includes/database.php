<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

//creiamo la classe database

class database{
	var $_nomedb = '';
	var $_db = '';
	var $_log = '';
	var $_pref_tabelle = '';
	var $_nQuery='0';
	var $_errorNum=0;
	var $_errorMsg='';
	var $_risultato = null;
	var $_resource = '';
	function database($host='localhost', $user, $pass, $nomedb, $pref_tabelle){
		//connessione al database
		if (!($this->_resource = @mysql_connect( $host, $user, $pass, true ))) {
			die("errore connessione");
			return false;
		}
		if ($nomedb != '' && !mysql_select_db( $nomedb, $this->_resource )) {
			die("errore selezione database");
			return false;
		}
		$this->_pref_tabelle = $pref_tabelle;
		$this->_nQuery = 0;
		$this->_log = array();
	}
	
	function setQuery( $query, $prefisso = '#__' ){
		$this->_sql=$this->sostituisciPrefisso( $query, $prefisso );
	}
	
	function sostituisciPrefisso( $sql, $prefisso = '#__' ){
		$sql = trim( $sql );

		$escaped = false;
		$quoteChar = '';

		$n = strlen( $sql );

		$startPos = 0;
		$literal = '';
		while ($startPos < $n) {
			$ip = strpos($sql, $prefisso, $startPos);
			if ($ip === false) {
				break;
			}

			$j = strpos( $sql, "'", $startPos );
			$k = strpos( $sql, '"', $startPos );
			if (($k !== FALSE) && (($k < $j) || ($j === FALSE))) {
				$quoteChar	= '"';
				$j			= $k;
			} else {
				$quoteChar	= "'";
			}

			if ($j === false) {
				$j = $n;
			}

			$literal .= str_replace( $prefisso, $this->_pref_tabelle, substr( $sql, $startPos, $j - $startPos ) );
			$startPos = $j;

			$j = $startPos + 1;

			if ($j >= $n) {
				break;
			}

			// quote comes first, find end of quote
			while (TRUE) {
				$k = strpos( $sql, $quoteChar, $j );
				$escaped = false;
				if ($k === false) {
					break;
				}
				$l = $k - 1;
				while ($l >= 0 && $sql{$l} == '\\') {
					$l--;
					$escaped = !$escaped;
				}
				if ($escaped) {
					$j	= $k+1;
					continue;
				}
				break;
			}
			if ($k === FALSE) {
				// error in the query - no end quote; ignore it
				break;
			}
			$literal .= substr( $sql, $startPos, $k - $startPos + 1 );
			$startPos = $k+1;
		}
		if ($startPos < $n) {
			$literal .= substr( $sql, $startPos, $n - $startPos );
		}
		return $literal;
	}
		
	//esecuzione query
	function query(){
		$this->_nQuery++;
		$this->_log[] = $this->_sql;
		$this->_errorNum = 0;
		$this->_errorMsg = '';
		$this->_risultato = mysql_query( $this->_sql, $this->_resource );
		if (!$this->_risultato) {
			$this->_errorNum = mysql_errno( $this->_resource );
			$this->_errorMsg = mysql_error( $this->_resource )." SQL=$this->_sql";
			debug($this->_errorMsg,'error');
			return false;
		}
		debug("Query ".$this->_nQuery." eseguita. ".$this->_sql);
		return $this->_risultato;
	}
	
	function getRigheInteressate(){
		return mysql_affected_rows( $this->query() );
	}
	
	function getNumRighe( $cur=null ){
		return mysql_num_rows( $cur ? $cur : $this->query() );
	}

	function getNumErrori(){
		return $this->_errorNum;
	}

	//ritorna il primo campo del risultato della query
	function caricaRisultato() {
		if (!($cur = $this->query())) {
			return null;
		}
		$ret = null;
		if ($row = mysql_fetch_row( $cur )) {
			$ret = $row[0];
		}
		mysql_free_result( $cur );
		return $ret;
	}

	//ritorna un array con il risultato di un unico campo
	function caricaArray($numinarray = 0) {
		if (!($cur = $this->query())) {
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_row( $cur )) {
			$array[] = $row[$numinarray];
		}
		mysql_free_result( $cur );
		return $array;
	}

	//ritorna un array con il risultato della query
	function caricaListaArray( $key='' ) {
		if (!($cur = $this->query())) {
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_assoc( $cur )) {
			if ($key) {
				$array[$row[$key]] = $row;
			} else {
				$array[] = $row;
			}
		}
		mysql_free_result( $cur );
		return $array;
	}

	/**
	* ritorna una lista di oggetti
	* ritorna null se la query fallisce
	*/
	function caricaListaOggetti( $unico=false ) {
		if (!($cur = $this->query())) {
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_object( $cur )) {
				$array[] = $row;
		}
		mysql_free_result( $cur );
		if($unico) return $array[0];
		return $array;
	}

	//ritorna una qualsiasi variabile della classe database
	function get( $_proprieta ){
		if(isset( $this->$_proprieta )) {
			return $this->$_proprieta;
		} else {
			return null;
		}
	}

	//setta una proprieta proprietà della classe database
	function set( $_property, $_valore ) {
		$this->$_proprieta = $_valore;
	}
	
	//ritorna un array con la lista delle tabelle del database
	function getListaTabelle() {
		$this->setQuery( 'SHOW TABLES' );
		return $this->caricaArray();
	}

	//ritorna la versione di mysql in uso
	function getVersion() {
		return mysql_get_server_info( $this->_resource );
	}
		

}



?>
