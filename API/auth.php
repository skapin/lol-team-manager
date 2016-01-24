<?php
require("include.php");


/**************   REGISTER     *****************/
if ( isset($_POST['register']) )
{
	$nom = getPost("nom");
	$prenom = getPost("prenom");
	$pseudo = getPost("pseudo",true);
	$mail = getPost("mail",true);
	$pass = getPost("pass",true);
	$passconf = getPost("passconf",true);
	
	if ( $passconf == $pass )
	{
		//$pass = password_hash( $pass, PASSWORD_DEFAULT);	
		$salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
		$salt = base64_encode($salt);
		$salt = str_replace('+', '.', $salt);
		$pass = crypt($pass, '$2y$10$'.$salt.'$');
		
		if ( !$pass )
		{
			$str .= '<p class="bg-danger">Erreur lors du hashage de votre mot de passe.</p>';
		}
		else
		{
			$req = "INSERT INTO `MBL_user` (nom, prenom, pseudo, mail, password, sel ) VALUES ( ?,?,?,?,?,? )";
			$vals = array( post2bdd($nom), post2bdd($prenom), post2bdd($pseudo), post2bdd($mail), post2bdd($pass), $salt );
			if ( Bdd::sql_insert( $req, $vals ) )
			{
				$str .= '<p class="bg-success">Votre compte a été crée avec succés !</p>';
			}
			else
			{
				$str .= '<p class="bg-danger">Erreur.</p>';
			}
		}
	}
	else
	{
		$str .= '<p class="bg-danger">Erreur, vos mot de passe ne correspondent pas.</p>';
	}
}


?>