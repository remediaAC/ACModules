<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

?>

<div class="debug-msg">
<ul>
<?php
global $debug;
foreach($debug as $msg)
echo "<li class=\"$msg->tipo\">$msg->messaggio</li>";
?>
</ul>
</div>
