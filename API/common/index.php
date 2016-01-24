<?php
require("include.php");

$page = new Page("MBL");


$page->html_printPage();


echo '
Pour profiter du site, il vous suffit de créer un compte en moins de 1 minute.
<br />
<br />
</p>

<p class="text-center"><img src="img/logo.png" alt="logo" />
<br />
<br />
<br />
<br /></p>
<div id="galerie">
	<a href="./img/mbl.png" rel="lightbox[roadtrip]"><img src="./img/mbl.png" height="450px" alt="img"/></a>
	<br />
	<hr />
	<br />
	<a href="./img/mbl2.png" rel="lightbox[roadtrip]"><img src="./img/mbl2.png" height="450px" alt="img"/></a>
	<br />
	<hr />
	<br />
	<a href="./img/mbl3.png" rel="lightbox[roadtrip]"><img src="./img/mbl3.png" height="450px" alt="img"/></a>
</div>



<h2>Fonctions à venir : </h2>
<p>
<ul>
	<li>Mes dernières lectures, Mes derniers livres,</li>
	<li>Demander le livre d\'un utilisateur,</li>
	<li>Référencer les livres connexes,</li>
	<li>Afficher les notes et moyenne des notes,</li>
	<li>Traiter les EPUB,</li>
	<li>Suppréssion des livres de la bibliotèques de manière collaborative,</li>
	<li>Dessiner arbre des connexions,</li>
	<li>Vignette,</li>
	<li>Valoriser un livre,</li>
	<li>Modifier les saisies,</li>
</ul>

</p>



';

echo '<br />
<br />
<br />
<br />
<p class="text-center"><img src="img/logo.png" alt="logo" /></p>';



$page->html_footer();
?>
