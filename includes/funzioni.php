<?php

//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

define( "_NOTRIM", 0x0001 );
define( "_ALLOWHTML", 0x0002 );
//parametri: da dove prendere la variabile ($_GET, $_POST, $_GET), nome variabile, nome da assegnare di default
function getParametri( &$arr, $name, $def=null, $mask=0 ) {
	$return = null;
	if (isset( $arr[$name] )) {
		if (is_string( $arr[$name] )) {
			if (!($mask&_NOTRIM)) {
				$arr[$name] = trim( $arr[$name] );
			}
			if (!($mask&_ALLOWHTML)) {
				$arr[$name] = strip_tags( $arr[$name] );
			}
			if (!get_magic_quotes_gpc()) {
				$arr[$name] = addslashes( $arr[$name] );
			}
		}
		return $arr[$name];
	} else {
		return $def;
	}
}

function caricaComponente( $nome ) {
	// carica qualche variabile globale normalmente usata dai componenti
	global $database, $config, $pagina;
	global $task, $Itemid, $id, $option, $gid, $pathSito;
	if(file_exists($config->pathSito ."/componenti/com_$nome/$nome.php"))
		include( $config->pathSito ."/componenti/com_$nome/$nome.php" );
	else
		$pagina->linkMancante();
}

/**
* Function to strip additional / or \ in a path name
* @param string The path
* @param boolean Add trailing slash
*/
function pathName($p_path,$p_addtrailingslash = true) {
	$retval = "";

	$isWin = (substr(PHP_OS, 0, 3) == 'WIN');

	if ($isWin)	{
		$retval = str_replace( '/', '\\', $p_path );
		if ($p_addtrailingslash) {
			if (substr( $retval, -1 ) != '\\') {
				$retval .= '\\';
			}
		}

		// Check if UNC path
		$unc = substr($retval,0,2) == '\\\\' ? 1 : 0;

		// Remove double \\
		$retval = str_replace( '\\\\', '\\', $retval );

		// If UNC path, we have to add one \ in front or everything breaks!
		if ( $unc == 1 ) {
			$retval = '\\'.$retval;
		}
	} else {
		$retval = str_replace( '\\', '/', $p_path );
		if ($p_addtrailingslash) {
			if (substr( $retval, -1 ) != '/') {
				$retval .= '/';
			}
		}

		// Check if UNC path
		$unc = substr($retval,0,2) == '//' ? 1 : 0;

		// Remove double //
		$retval = str_replace('//','/',$retval);

		// If UNC path, we have to add one / in front or everything breaks!
		if ( $unc == 1 ) {
			$retval = '/'.$retval;
		}
	}

	return $retval;
}

/**
* Funzione per leggere i file in una directory
* @param string The file system path
* @param string A filter for the names
* @param boolean Recurse search into sub-directories
* @param boolean True if to prepend the full path to the file name
*/
function leggiCartella( $path, $filter='.', $recurse=false, $fullpath=false  ) {
	$arr = array();
	if (!@is_dir( $path )) {
		return $arr;
	}
	$handle = opendir( $path );

	while ($file = readdir($handle)) {
		$dir = pathName( $path.'/'.$file, false );
		$isDir = is_dir( $dir );
		if (($file != ".") && ($file != "..")) {
			if (preg_match( "/$filter/", $file )) {
				if ($fullpath) {
					$arr[] = trim( pathName( $path.'/'.$file, false ) );
				} else {
					$arr[] = trim( $file );
				}
			}
			if ($recurse && $isDir) {
				$arr2 = leggiCartella( $dir, $filter, $recurse, $fullpath );
				$arr = array_merge( $arr, $arr2 );
			}
		}
	}
	closedir($handle);
	asort($arr);
	return $arr;
}

/*
 * funzione dividiparametri
 * 
 * riceve una stringa formata da proprietà=valore
 * e la divide in un oggetto o in un array
 * a seconda del parametro
 * boolean $asArray
 * 
 * 
 * 
 * */
function dividiParametri($txt, $asArray=false){
	if(is_string($txt)){
		$linee=explode( "\n", $txt );
	} else if (is_array( $txt )) {
		$linee = $txt;
	} else {
		$linee = array();
	}
	
	foreach($linee as $linea){
		$linea=trim($linea);
		$pos = strpos( $linea, '=' );
		$proprieta = trim( substr( $linea, 0, $pos ) );
		if( $proprieta ){
			$valore = trim( substr( $linea, $pos + 1 ) );
			if( $valore == 'true'){
				$valore = true;
			}else if( $valore == 'false'){
				$valore = false;
			}
			if($asArray){
				$obj[$proprieta]=$valore;
			}else{
				$obj->$proprieta = $valore;
			}
		}
	}
	
	return $obj;
}

class gestionePlugin {
	
}


function debug($str, $tipo = 'success'){
	global $debug;	
	$obj=null;
	$obj->messaggio=$str;
	$obj->tipo=$tipo;
	$debug[]=$obj;
}

?>
