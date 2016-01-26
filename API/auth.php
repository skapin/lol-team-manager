<?php
require_once ('include.php');

function is_logged()
{
    return ( !empty($_SESSION['username']) );
}

function start_session()
{
    if (session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
    else if(session_id() == '')
    {
        session_start();
    }
}

function loggin()
{
    $_SESSION['username'] = getPost("pseudo");
    $pass = getPost("password");

    $datas = Bdd::sql_fetch_array_assoc( "SELECT *
                                            FROM LOL_user
                                            WHERE pseudo=?",array($this->get_pseudo()) ) ;
    if ( $data[0] == 0)
    {
        return false;
    }

    $_SESSION['id_user'] = $datas[1]['id'];
    $_SESSION['nom']     = $datas[1]['nom'];
    $_SESSION['prenom']  = $datas[1]['prenom'];
    $_SESSION['pseudo']  = $datas[1]['pseudo'];
    $_SESSION['mail']    = $datas[1]['mail'];
    $_SESSION['pass']    = $datas[1]['password'];
    return true;
}
function loggout()
{
    unset( $_SESSION['username']);
    session_destroy();
    session_start();
}

