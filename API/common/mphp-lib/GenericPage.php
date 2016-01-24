<?php
/**
 * @brief class de creation de page Html.
 * @file GenericPage.php
 * @since septembre 2010
 * @author SkapiN
 **/
class GenericPage
{
	protected $titre;
	private $charset;
	private $doc_type;
	private $is_html5=false;
	private $array_css = array();
	private $array_js = array();
	protected $session = false;

	public function __construct( $title="MyPage", $set_html5=false ) {
		$this->start_session();
		$this->titre = $title;
		$this->is_html5 = $set_html5;
		if ( $this->is_html5)
		{
			$this->setDocType('<!DOCTYPE html>');
		}
		else
		{
			$this->setDocType( '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' );
		}
		$this->setCharset('UTF-8');
  }
	public function __destruct() {
		if ( $this->session )
		{
 /*           @session_unset();
			@session_destroy();
			session_destroy();*/
		}
	}
	public function setDocType( $doc )
	{
		$this->doc_type = $doc;
	}
	public function setCharset( $chars )
	{
		$this->charset = $chars;
	}

	public function html_header() {
		if ( $this->is_html5 )
		{
			echo $this->doc_type.'
<html lang="fr">
  <head>
	<meta charset="'.$this->charset.'" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	';

		}
		else
		{
			echo $this->doc_type.'
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
	<meta http-equiv="content-type" content="text/html; charset='.$this->charset.'" />';

		}

		echo '<title>', $this->titre,'</title>
	';
		foreach( $this->array_css as $current_css ) {
			echo '<link href="'. $current_css['file'] . '" rel="stylesheet" title="'. $current_css['title'] . '" type="text/css" media="'. $current_css['media'] . '" />
	';
		}
		foreach ( $this->array_js as $current_js ) {
			echo '<script type="text/javascript" src="' . $current_js . '"></script>
			';
		}
		echo'
  </head>
  <body role="document">
';

	}
	public function html_footer() {
			echo '<!--*******************************************Pied de page**************************************************-->
	<div id="bas" >
		<p id="bas_txt"><span id="version"></span>
		<a href="" 	id="lien_mail" style="color:#AAAAAA;"></a></p>
	</div>
  </body>
</html>
';
	}
	static public function start_session_once()
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		else if(session_id() == '')
		{
			session_start();
		}
	}
	public function start_session() {
		//obz_start() ??

		if ( !session_start() ) {
			echo "session start failed";//print_error("La session n'a pas pu demarrer");
		}
		else
		{
			$this->session = true;
		}

	}

	public function addSheet( $file, $title='defaultStyle', $media='screen' )
	{//Warning : perhapse security fail. (include fail, valide file ?)
		$this->array_css[]=array ('file' => $file, 'title'=>$title, 'media'=>$media );
	}

	public function addJs( $file )
	{
		$this->array_js[] = $file;
	}
}?>
