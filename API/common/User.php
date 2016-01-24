<?php
require_once ('include.php');

class User  { 
    static public $table_user="MBL_user";
    
    public function __construct() {
    }

    static public function getAll()
    {
		$table_user = User::$table_user;
		$membres = Bdd::sql_fetch_array_assoc( "
		SELECT ".$table_user.".pseudo, ".$table_user.".id as IDD, count(MBL_fiche_lecture.id_user) as NBR_LECTURE,
( SELECT count(MBL_biblio.id_user) FROM ".$table_user." JOIN MBL_biblio ON ".$table_user.".id=MBL_biblio.id_user  WHERE ".$table_user.".id =IDD) as NBR_LIVRE
FROM `".$table_user."` 
LEFT OUTER JOIN MBL_fiche_lecture ON ".$table_user.".id=MBL_fiche_lecture.id_user
GROUP BY ".$table_user.".id, MBL_fiche_lecture.id_user" );								
		return $membres;
	}
	
	
}
