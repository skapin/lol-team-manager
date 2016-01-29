<?php
require_once ('include.php');

print($_SERVER['REQUEST_METHOD']);
var_dump($_POST);
/**************   REGISTER     *****************/
if ( isset($_POST['register']) )
{
	print 'aa';
	$pseudo = getPost("pseudo",true);
	//$mail = getPost("mail",true);
	$pass = getPost("password",true);
	$passconf = getPost("password_confirmation",true);
	$region = 'euw';

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
			$req = "INSERT INTO `user` (user_name, user_mdpsecret, user_region, sel ) VALUES ( ?,?,?,? )";
			$vals = array( post2bdd($pseudo),post2bdd($pass), post2bdd($region), $salt );
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