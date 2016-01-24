<?php
require("include.php");

if ( empty($_POST['titre']) )
{
	echo "Error getting livre";
}
else
{
	$page = new Page();
	
	$livres =  Livre::getAllLike( 'titre', array( '%'.str_replace("'","%",$_POST['titre']).'%') );

	echo Page::getLivreTabFormated( $livres );
}
