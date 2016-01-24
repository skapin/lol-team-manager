<?php


public function loggin()
{
	$_SESSION['username'] = getPost("pseudo");
	$pass = getPost("password");

	$datas = Bdd::sql_fetch_array_assoc( "SELECT *
												FROM MBL_user 
												WHERE pseudo=?",array($this->get_pseudo()) ) ;
	$_SESSION['id_user'] = $datas[1]['id'];
	$_SESSION['nom'] = $datas[1]['nom'];
	$_SESSION['prenom'] = $datas[1]['prenom'];
	$_SESSION['pseudo'] = $datas[1]['pseudo'];
	$_SESSION['mail'] = $datas[1]['mail'];
	$_SESSION['pass'] = $datas[1]['password'];


}
public function loggout()
{
	unset( $_SESSION['username']);
	session_destroy();
	session_start();
}