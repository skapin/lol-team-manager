<?php
require_once ('include.php');


if ( empty($_GET['USER_ID'])  )
{
	echo "No User ID Provided";
	exit;
}
if ( empty($_GET['ACTION'])  )
{
	echo "No Action Provided";
	exit;
}

if ( $_GET['ACTION'] == 'get_team_by_user' )
{




}
else if ( $_GET['ACTION'] == 'get_champ_by_user' )
{


}
else if ( $_GET['ACTION'] == 'get_user_role' )
{


}