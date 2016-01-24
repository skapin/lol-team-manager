<?php
require_once ('include.php');

$GLOBALS['__form_token_csrf_name__'] = 'jtncsrffrmfrmw';
$GLOBALS['truncate_field_size'] = 40 ;

class Page extends GenericPage {
	private $css;
	private $current_menu;
	static public $scrollServiceUrl = array('liste_livres','mes_livres');

	public function __construct($titre="") {
		parent::__construct("..::MyBookList::..   ~". $titre."~", true);
		$this->current_menu = $titre;
		$this->addSheet('bootstrap/css/bootstrap.min.css');
		$this->addSheet('bootstrap/css/bootstrap-theme.min.css');

		$this->addSheet('css/theme.css');
		$this->addSheet('bootstrap-combobox/css/bootstrap-combobox.css');
		$this->addSheet('tinybox2/style.css');


		$this->addJS('jQuery-Autocomplete/dist/jquery.autocomplete.js');
		$this->addJS('js/jquery-2.1.1.js');
		$this->addJS('js/infinityscroll.js');
		$this->addJS('tinybox2/tinybox.js');

		if ( isset($_POST['sign-in']) && !$this->is_logged() && $this->session)
		{
			$this->loggin();
		}
		if ( isset($_POST['sign-out']) && $this->is_logged() && $this->session)
		{
			$this->loggout();
		}

	}
	function __destruct() {
		unset($_SESSION['filter_livre']);
	}

	static public function createCSRF()
	{
		Page::start_session_once();
		$token_jeton = md5(time()*rand(1,10));
		//on stock sur le serveur
		$_SESSION[$GLOBALS['__form_token_csrf_name__']] = $token_jeton;

		//on stock sur le client
		setcookie( $GLOBALS['__form_token_csrf_name__'], $token_jeton, time()+3600*2, '/', $_SERVER['SERVER_NAME']); // 2 heures de validité
		return $token_jeton;
	}

	static public function checkCSRF()
	{
		if ( isset($_SESSION[$GLOBALS['__form_token_csrf_name__']]) && isset($_COOKIE[$GLOBALS['__form_token_csrf_name__']]) && $_SESSION[$GLOBALS['__form_token_csrf_name__']] == $_COOKIE[$GLOBALS['__form_token_csrf_name__']] )
		{
			unset($_SESSION[$GLOBALS['__form_token_csrf_name__']]);
			if(isset($_COOKIE[$GLOBALS['__form_token_csrf_name__']]))
			{
				unset($_COOKIE[$GLOBALS['__form_token_csrf_name__']]);
				setcookie($GLOBALS['__form_token_csrf_name__'], '', time() - 3600); // empty value and old timestamp
			}
			return true;
		}
		else
		{
			unset($_SESSION[$GLOBALS['__form_token_csrf_name__']]);
			if(isset($_COOKIE[$GLOBALS['__form_token_csrf_name__']]))
			{
				unset($_COOKIE[$GLOBALS['__form_token_csrf_name__']]);
				setcookie($GLOBALS['__form_token_csrf_name__'], '', time() - 3600); // empty value and old timestamp
			}
			return false;
		}

	}
	public function html_printPage($menu=true, $seeCodeSource = false) {


		$this->html_header();

		$this->html_head();
		if ( $menu )
		{
			$this->html_topbar();
			$this->html_menu();
		}
		//<div class="jumbotron">
		echo '
	  <div id="corps">
		<div class="container theme-showcase" role="main">
			<div class="jumbotron">

			<p id="notification-topbar-danger" class="bg-danger"></p>
			<p id="notification-topbar-success" class="bg-success"></p>
			<p id="notification-topbar-warning" class="bg-warning"></p>
			';

		if ( $seeCodeSource && !empty($_GET['scs']) )
		{
			$this->printSource();
			$this->html_footer();
			die();
		}

	}

	public static function is_logged()
	{
		return ( !empty($_SESSION['username']) );
	}
	public function get_pseudo()
	{
		if ( $this->is_logged() )
		{
			return ( $_SESSION['username']) ;
		}
		else
		{
			return "Not Logged";
		}
	}
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

	static public function sourceOf( $file, $type='php' )
	{
		$file = str_replace ( '..' , '' , $file );
		$data = '<div class="code_source">';
		$data .= '<br />';
		$data .= '<p class="legend" >Fichier : '.$file.'</p>';
		$data .= StAx( StAx_loadSourceFile( $file ), $type, StAxStyle::LittleScrollArea . StAxStyle::Sober1 );
		$data .= '</div>';
		return $data;
	}

	private function printSource(  )
	{
		echo '<div class="code_source">';
		echo StAx( StAx_loadSourceFile( substr($_SERVER['SCRIPT_NAME'],1) ), 'php' );
		echo '</div>';
	}
	public function html_menu() {

	}
	public function html_topbar() {
		$str='
		 <!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	  <div class="container">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="index.php">Accueil</a>
		</div>
		<div class="navbar-collapse collapse">
		  <ul class="nav navbar-nav">
			<li class="dropdown" >
			<a href="index.php" ';
			$str .= $this->current_menu == "biblioteque" ? 'class="active dropdown-toggle' : 'class="dropdown-toggle" data-toggle="dropdown">Biblioteque<span class="caret"></span></a>
			  <ul class="dropdown-menu" role="menu">
				<li class="dropdown-header">Communauté</li>
				<li><a href="liste_livres.php">Liste des Livres</a></li>';
			if ( $this->is_logged() )
			{
				$str .= '<li class="divider"></li>
				<li class="dropdown-header">Perso</li>
				<li><a href="mes_lectures.php">Mes Lectures</a></li>
				<li><a href="mes_livres.php">Mes Livres</a></li>
				<li><a href="mes_souhait.php">Mes Souhaits</a></li>
				<li class="divider"></li>
				<li class="dropdown-header">GraphO</li>
				<li><a href="#">BiblioGrapho</a></li>';
			}
			  $str .='</ul>
			</li>
			';
			$str .= '<li class="dropdown';
			$str .= $this->current_menu == "Communaute" ? ' active' : "";
			$str .= '"><a href="communaute.php" class="dropdown-toggle" data-toggle="dropdown">Communaute<span class="caret"></span></a>
			  <ul class="dropdown-menu" role="menu">
				<li class="dropdown-header">Informations</li>
				<li><a href="membres.php">Les Membres</a></li>
				<li><a href="top.php">Les Top</a></li>
				<li class="divider"></li>
				<li class="dropdown-header">Communication</li>
				<li><a href=""></a></li>
			  </ul>
			</li>';
			if ( $this->is_logged() )
			{
				$str .= '<li ';
				$str .= $this->current_menu == "compte" ? 'class="active"' : "";
				$str .='><a href="compte.php">Mon compte</a></li>';
			}
			$str .= '<li ';
			$str .= $this->current_menu == "Bugs" ? 'class="active"' : "";
			$str .='><a href="bugs.php">Bugs</a></li>';
			$str .= '<li ';
			$str .= $this->current_menu == "contact" ? 'class="active"' : "";
			$str .='><a href="contact.php">Contact</a></li>';

		  $str .='</ul>';

			if ( $this->is_logged() )
			{
				$str.= '
		  <form class="navbar-form navbar-right" role="form" action="#" method="post">
			<label id="pseudoLabel" for="'.$this->get_pseudo().'">'.$this->get_pseudo().'</label>
			<button type="submit" class="btn btn-danger" name="sign-out">Sign Out <span class="glyphicon glyphicon-log-out"></span></button>
		  </form>';
			}
			else
			{
				$str.= '
		  <form class="navbar-form navbar-right" role="form" action="compte.php" method="post">
			<div class="form-group">
			  <input type="text" placeholder="Pseudo" class="form-control" id="pseudo" name="pseudo">
			</div>
			<div class="form-group">
			  <input type="password" placeholder="Password" class="form-control" name="password" id="password" >
			</div>
			<button type="submit" class="btn btn-success" name="sign-in" >Sign in <span class="glyphicon glyphicon-log-in"></span></button>
		  </form>
		  <form class="navbar-form navbar-right" role="form" action="register.php">
			<button type="submit" class="btn btn-info" >S\'inscrire</button>
		  </form>';
			}

		  $str.= '
		</div><!--/.nav-collapse -->
	  </div>
	</div> ';
		echo $str;
	}

	public function html_head() {
		echo '
	<!--*****************HEAD****************-->
	<header></header>
';

	}

	public function getUserForm()
	{
		$pass = "...";
		if ( $this->is_logged() )
		{
			$nom = $_SESSION['nom'];
			$prenom = $_SESSION['prenom'];
			$pseudo = $_SESSION['pseudo'];
			$mail = $_SESSION['mail'];
		}
		else
		{
			$nom = "...";
			$prenom = "...";
			$pseudo = "...";
			$mail = "...";
		}
		$str = form_preped_text("","nom","Nom",$nom,1,0);
		$str .= form_preped_text("","prenom","Prenom",$prenom,1,0);
		$str .= form_preped_text("","pseudo","Pseudo",$pseudo,1,0);
		$str .= form_preped_text("","mail","Mail",$mail,1,0);
		$str .= form_preped_text("","pass","Password",$pass,1,0,"","password");
		return $str;

	}
	public function html_footer( $seeSourceCode=false ) {
		echo '
		</div><!-- /jombu -->
	</div><!-- /container -->
</div><!-- /corps -->';
		if ( $seeSourceCode && empty($_GET['scs']) )
		{
			echo '<footer><a href="?scs=1" title="code" > &gt;Code de la Page&lt; </a>';
		}
	else
	  echo '<footer>';
		echo'
		</footer>

		<!-- /container -->
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/js/docs.min.js"></script>
	<script src="bootstrap-combobox/js/bootstrap-combobox.js" type="text/javascript"></script>
	<script src="js/functions.js"></script>
	</body>
</html>';
		//GenericPage::html_footer();
	}

	public function tab_begin( $titre, $css_class='cv' )
	{
		return '
<table class="'.$css_class.'" >
	<thead>
		<tr>
			<th colspan="2" >'.$titre.'</th>
		</tr>
	</thead>
	<tbody>
';
	}

	public function tab_addRow( &$tab, $col1, $col2 )
	{
		$tab.='            <tr><td class="col1" >' .$col1.'</td><td class="col2">'.$col2.'</td></tr>';
	}
	public function tab_end( &$tab)
	{
		$tab.='
	</tbody>
</table>';
	}

	static public function getAbbr( $value, $len )
	{
		if ( strlen($value) > $len )
			return '<abbr title="'.$value.'"> '.truncate( $value, $len).'</abbr>';
		else
			return $value;
	}
}
?>