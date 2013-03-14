<?php
//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">
<head>
<title><?php echo $pagina->getTitolo()." | ".$conf->nomeSito; ?></title>
<script type="text/javascript" src="<?php echo $conf->urlSito; ?>/templates/default/tiny_mce/tiny_mce.js"></script>
<script>for(x in document.write){document.write(x);}</script>
<script type="text/javascript">
tinyMCE.init({
mode : "textareas"
});
</script>
<style type="text/css">

body {
	margin:0;
	padding:0;
	border:0;			/* This removes the border around the viewport in old versions of IE */
	width:100%;
	background:#fff;
	min-width:600px;    	/* Minimum width of layout - remove line if not required */
					/* The min-width property does not work in old versions of Internet Explorer */
	font-size:90%;
}

h1, h2, h3 {
	margin:.8em 0 .2em 0;
	padding:0;
}
p {
	margin:.4em 0 .8em 0;
	padding:0;
}
/* Header styles */
#header {
	clear:both;
	float:left;
	width:100%;
}
#header {
	border-bottom:1px solid #000;
}
#header p,
#header h1,
#header h2 {
	padding:.4em 15px 0 15px;
	margin:0;
}
#header ul {
	clear:left;
	float:left;
	width:100%;
	list-style:none;
	margin:10px 0 0 0;
	padding:0;
}
#header ul li {
	display:inline;
	list-style:none;
	margin:0;
	padding:0;
}
#header ul li a {
	display:block;
	float:left;
	margin:0 0 0 1px;
	padding:3px 10px;
	text-align:center;
	background:#eee;
	color:#000;
	text-decoration:none;
	position:relative;
	left:15px;
	line-height:1.3em;
}
#header ul li a:hover {
	background:#369;
	color:#fff;
}
#header ul li a.active,
#header ul li a.active:hover {
	color:#fff;
	background:#000;
	font-weight:bold;
}
#header ul li a span {
	display:block;
}
/* 'widths' sub menu */
#layoutdims {
	clear:both;
	background:#eee;
	border-top:4px solid #000;
	margin:0;
	padding:6px 15px !important;
	text-align:right;
}
/* column container */
.colmask {
	position:relative;	/* This fixes the IE7 overflow hidden bug */
	clear:both;
	float:left;
	width:100%;			/* width of whole page */
	overflow:hidden;		/* This chops off any overhanging divs */
}
/* common column settings */
.colright,
.colmid,
.colleft {
	float:left;
	width:100%;
	position:relative;
}
.col1,
.col2,
.col3 {
	float:left;
	position:relative;
	padding:0 0 1em 0;
/*	overflow:hidden;*/
}
/* 2 Column (left menu) settings */
.leftmenu {
	background:#fff;		/* right column background colour */
}
.leftmenu .colleft {
	right:75%;			/* right column width */
	background:#f4f4f4;	/* left column background colour */
}
.leftmenu .col1 {
	width:71%;			/* right column content width */
	left:102%;			/* 100% plus left column left padding */
}
.leftmenu .col2 {
	width:21%;			/* left column content width (column width minus left and right padding) */
	left:6%;			/* (right column left and right padding) plus (left column left padding) */
}
/* Footer styles */
#footer {
	clear:both;
	float:left;
	width:100%;
	border-top:1px solid #000;
}
#footer p {
	padding:10px;
	margin:0;
}

body{
color:#1B1B1B;
font-family:"Lucida Grande",Arial,Helvetica,Verdana,sans-serif;
}

ul.albums{
list-style-image:none;
list-style-position:outside;
list-style-type:none;
font-size:12px;
}

ul.albums li{
display:inline;
float:left;
margin-bottom:30px;
position:relative;
width:49.5%;
line-height:1.25;
}

ul.albums li.odd{
clear:both;
}

ul.albums li .album{
min-height:135px;
padding:0 15px 0 155px;
vertical-align:top;
}

.album-cover{
display:inline;
float:left;
margin:0 0 0 -155px;
height:131px;
width:138px;
position:relative;
}

.album a{
color:#1B1B1B;
text-decoration:none;
}

.album-cover img.cover{
clip:rect(0pt, 126px, 126px, 0pt);
left:11px;
top:3px;
display:block;
position:absolute;
border:0 none;
}

.cover-case{
background-image:url("templates/default/imgs/cover.png");
height:134px;
left:0;
width:141px;
background-position:left top;
background-repeat:no-repeat;
display:block;
position:absolute;
top:0;
}

.biografiaArtista{
font-size:12px;
line-height:1.5em;
margin:10px 0;
}

.statArtista{
color:#696969;
font-size:11px;
line-height:1.36364em;
margin:-12px 3px;
}

.infoArtista .cover-case{
background: url("templates/default/imgs/jewelcase_medium.png");
height:68px;
width:73px;
}

.infoArtista .album-cover{
margin: 0 0 0 -100px;
height:75px;
width:75px;
}

.infoArtista .album-cover img.cover{
left:7px;
}

.infoArtista .album{
min-height: 70px !important;
}

.infoArtista .album-cover img.cover{
width: 64px !important;
}

.album .artista{
font-size:11px;
}

.album a:hover {
text-decoration:underline;
}

.album .copy,
.albumInfo .infoAlbum .copy{
color:#696969;
font-size:10px;
font-weight: normal;
}

.albumInfo{
min-height:135px;
}
.albumInfo .infoAlbum{
padding-left:20px;
font-weight:bold;
}

.infoAlbum a{
color:#696969;
font-weight:bold;
text-decoration:none;
}

.infoAlbum a:hover{
text-decoration:underline;
color: #0187C5;
}

table thead{
font-weight:bold;
}

table td.ordine{
width:6%;
text-align:right;
padding-right:10px;
}

.modulo{
border:1px dotted #cccccc;
}
li.warning{
color: #cc5511;
}
li.error{color: red;}
li.success{color:green;}

div.messaggi{
width:80%;
border:2px solid black;
margin: 15px auto;
padding: 10px;
}

div.messaggi.errore{
border-color:#d80000;
background-color:#ffcdcd;
}

div.messaggi.stato{
border-color:#00d000;
background-color:#ccffcc;
}

div.messaggi.warning{
border-color:#ffba00;
background-color:#fff0c7;
}
.contenitore{
width:100%;
}
.paginazione{
margin: 0 auto;
display: table;
}

.paginazione .selettore,
.paginazione .contatoreRisultati,
.paginazione .contatorePagine,
.paginazione .contatorePaginatore{
display:inline;
float:left;
margin: 0 10px;
}

.clear{clear:both;}
</style>
</head>
<body>
<div id="header">
	
</div>
<div class="colmask leftmenu">
	<div class="colleft">
		<div class="col1">
			<!-- Column 1 start -->
			<h1><?php echo $pagina->getTitolo(); ?></h1>
			<?php $pagina->stampaMessaggi(); ?>
			<?php echo $contenuto; ?>

			<!-- Column 1 end -->
		</div>
		<div class="col2">
			<!-- Column 2 start -->
			<?php echo caricaModuli('left'); ?>
			<!-- Column 2 end -->
		</div>
	</div>
</div>
<div id="footer">
	<?php echo caricaModuli('footer'); ?>
</div>

</body>
</html>

