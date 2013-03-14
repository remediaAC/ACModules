<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

$erroreForm=false;
$errori=array();
if(getParametri($_POST,'inviato', false)){

$pwd1 = trim(getParametri($_POST,'pwd1', false));
$pwd2 = trim(getParametri($_POST,'pwd2', false));
$username = trim(getParametri($_POST,'username', false));
$email = trim(getParametri($_POST,'email', false));
$emailValida=eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);

if($username && $pwd1 && ($pwd1==$pwd2) && $emailValida){
//inserisci in db

$q="INSERT INTO #__utenti (`id`, `username`, `password`, `nome`, `email`, `abilitato`, `idGruppo`, `dataRegistrazione`) VALUES (NULL,'$username','$pwd1','$username','$email', '1', '1', NOW())";
$database->setQuery($q);
if(!$database->query()){
$errori[]="Errore nell'inserimento. Prova con un altro username.";
$erroreForm=true;
$username='';
}else{
$pagina->setTitolo("Registrazione effettuata correttamente!");
echo "<p>Ora puoi effettuare il login</p>";
}

}else{
	$erroreForm=true;
	if($pwd1!=$pwd2){
		$errori[]="Le password non coincidono";
	}
	if(!$username){
		$errori[]="Devi compilare anche il campo username";
	}
	if(!$emailValida){
		$errori[]="Devi compilare il campo email correttamente";
	}
}
}

if(!getParametri($_POST,'inviato', false) || $erroreForm){

$pagina->setTitolo("Pagina di registrazione utenti");

if($erroreForm){
echo "<div class=\"errori\" style=\"color:red;\"><ul>";
foreach($errori as $errore){
echo "<li>$errore</li>";
}
echo "</ul></div>";
}

?>

<form name="registrazione" method="POST" action="?option=com_registrazione">

<input type="hidden" value="true" name="inviato">

Username:
<input type="text" name="username" value="<?php echo $username?>"/>
<br />
Password:
<input type="password" name="pwd1" />
<br />
Conferma Password:
<input type="password" name="pwd2" />
<br />
Email:
<input type="text" name="email" value="<?php if($emailValida) echo $email; ?>" />
<br />
<input type="submit" value="Submit" />

</form>

<?php
}
?>
