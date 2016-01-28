<?php
/**
 * @file Bdd.php
 * @since septembre 2010
 * @author SkapiN
 * @brief class de d'acces aux bases de donnée.
 **/
class Bdd {
/**
 * @brief PDO object
 **/
    private $bdd;

    public function __construct () {
        $bdd = false;
        $bdd = $this->connect();
    }

    public function __destruct() {
        //uselss        disconnect();
    }

/**
* @brief  Retourne l'instance Bdd() en GLOBALS['bdd']. Si elle n'existe pas, elle sera créé.
* @return Bdd(), retourne une instance de la class Bdd().
**/
    static function sql_get_global_bdd()
    {
        if ( empty($GLOBALS['bdd']) )
            $GLOBALS['bdd'] = new Bdd();
        return $GLOBALS['bdd'];
    }
/**
* @brief  retourne une requete PDO:: preparé et executé. Si une erreur intervient, un die() est lancé accompagné d'un message d'erreur.
* @param $req requete SQL
* @param $vars= array() contient les valeurs nécéssaires a la préparation de la requete.
* @return requete PDO:: preparé et executé
**/
    static public function sql_fetch( $req, $vars = array() )
    {
        $tmp_req = Bdd::sql_get_global_bdd();
        $tmp_req = $tmp_req->pdo();

        $tmp_req = $tmp_req->prepare( $req );
        //$tmp_req->setFetchMode(PDO::FETCH_ASSOC);
        if ( !($tmp_req->execute( $vars )) )
            {
                if ( $GLOBALS['debug'] )
                {
                    print_r($tmp_req->errorInfo());
                    echo '<br />';
                }
                echo 'Bdd:: sql_fetch echou&eacute; #19.17.6'.'<br />';

                die();
            }
        return $tmp_req;
    }
/**
* @brief  retourne un array() formaté apres execution d'une requete PDO:: preparée.
* @param $req requete SQL
* @param $vars= array() contient les valeurs nécéssaires a la préparation de la requete.
* @return array() formaté. $array[0] contient le nombre delement retourné par la requete SQL. $array[$i>0], la valeur retourné par la requete SQL.
**/
    static function sql_fetch_array( $req, $vars = array() )
    {
        $tmp_req = Bdd::sql_fetch( $req, $vars );
        $contenu[0]=0;
        while ($contenu[] = $tmp_req->fetch(PDO::FETCH_NUM) )
            $contenu[0]++;
        return $contenu;
    }

    static function sql_fetch_array_assoc( $req, $vars = array() )
    {
        $tmp_req = Bdd::sql_fetch( $req, $vars );
        $contenu[0]=0;
        while ($contenu[] = $tmp_req->fetch(PDO::FETCH_ASSOC) )
            $contenu[0]++;
        return array_filter($contenu);//remove empty value
    }
/**
* @brief  execute une insertion SQL préparé.
* @param $req requete SQL
* @param $vars= array() contient les valeurs nécéssaires a la préparation de la requete.
* @return true si l'insertion c'est bien passé
**/
    static function sql_insert( $req, $vars = array() )
    {
        $tmp_req = Bdd::sql_get_global_bdd();
        $tmp_req = $tmp_req->pdo()->prepare( $req );
        $ret_req = $tmp_req->execute( $vars );
         if ( !($ret_req) && $GLOBALS['debug'] )
             {
                     echo 'Bdd:: insertion echou&eacute; #19.17.8'.'<br />';
                        if ( $GLOBALS['debug'] )
                        {
                                print_r($tmp_req->errorInfo());
                                echo '<br />';
                        }
                     return false;
         }
             return $ret_req;
    }
    public function connect($host = false, $port=false, $base=false, $user=false, $passwd=false ) {

        try {
            if ( $GLOBALS['sql_engine'] == 'sqlite')
            {
                $this->bdd = new PDO('sqlite:'.$GLOBALS['sql_base']);
            }
            else
            {
                if ( !$host )
                    $sql_host = $GLOBALS['sql_host'];
                if ( !$port )
                    $sql_port = $GLOBALS['sql_port'];
                if ( !$base )
                    $sql_base = $GLOBALS['sql_base'];
                if ( !$user )
                    $sql_user = $GLOBALS['sql_user'];
                if ( !$passwd )
                    $sql_pass = $GLOBALS['sql_pass'];
                $this->bdd = new PDO('mysql:host='.$sql_host.';dbname='.$sql_base, $sql_user, $sql_pass);
            }
        }
        catch (Exception $e) {
            echo '#BDD::# Une erreur est survenue ! #19.17.12';
            print ($e->getMessage());
            die();
        }
    }
    /**
    * @brief permet de recuperer l'id du dernier champ ajout�
    * @return retourne l'id du dernier champ ajouter a la base de donn�e
    **/

    static public function lastInsertId()
    {
        $tmp_req = Bdd::sql_get_global_bdd();
        return $tmp_req->pdo()->lastInsertId();
    }

    public function disconnect() {
        if ( $bdd != false  )
            unset( $bdd );
    }
    public function pdo() {
        return $this->bdd;
    }

    function prepare($req) {
        $bdd->prepare( $req );
    }
    static public function exist( $db_name )
    {
      $tmp_req = Bdd::sql_get_global_bdd()->pdo();
      //      $tmp_req->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
      $tmp_req = $tmp_req->query("SELECT count(*) FROM $db_name");
      $tmp_req = (gettype($tmp_req));
      return  !( is_bool($tmp_req ));

    }
}

?>
