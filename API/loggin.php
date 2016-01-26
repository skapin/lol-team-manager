<?php
require_once ('include.php');

if (  isset($_POST['is_logged']) )
{
    return is_logged();
}

if (  isset($_POST['loggin']) )
{
    return loggin();
}

if (  isset($_POST['logout']) )
{
    return loggout();
}


