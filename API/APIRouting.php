<?php
require_once ('include.php');
require_once ('LOL.php');


if ( empty($_GET['ACTION'])  )
{
    echo "No Action Provided";
    exit;
}

/*********************** PUBLIC ACCESS **********************************************/
if ( $_GET['ACTION'] == 'get_lol_user_info' && isset($_GET['pseudo']) )
{
    $l = new Lol();
    print($l->getSummonerInfo($_GET['pseudo'], true) );
    exit;
}

if ( empty($_GET['USER_ID'])  )
{
	echo "No User ID Provided";
	exit;
}

/*********************** PRIVATE ACCESS **********************************************/
if ( $_GET['ACTION'] == 'get_team_by_user' )
{




}
else if ( $_GET['ACTION'] == 'get_my_champion_list' )
{


}
else if ( $_GET['ACTION'] == 'get_user_role' )
{


}
