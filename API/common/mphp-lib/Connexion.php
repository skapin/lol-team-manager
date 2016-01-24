<?php

class Connexion
{
	private $method = 'GET';
	private $agent = 'Private browser (Debian rox) 1.0';
	private $options;

	function __construct($cookies = array(), $data = array(), $header = array())
	{
		$content = http_build_query($data, '', '&');

		$headers = $header;
		$headers['cookie'] = $this->http_build_cookies($cookies);
		$headers['Content-Length'] = strlen($content);
		$headers = $this->http_build_headers($headers);

		$this->options = array('http' => array('user_agent' => $this->agent,
											   'method' => $this->method,
											   'content' => $content,
											   'header' => $headers));
	}

	public function get($url)
	{
		$context = stream_context_create($this->options);

		if(!($flux = fopen($url, 'r', false, $context)))
			return FALSE;

		$meta = stream_get_meta_data($flux);
		$headers = $meta['wrapper_data'];

		$return = '';

		while(!feof($flux))
		   if(!($return .= fread($flux, 1024)))
			break;

		fclose($flux);

		return $return;
	}

	private function http_build_headers($headers)
	{
		$return = '';

		foreach($headers as $name => $value)
			$return .= $name . ': ' . $value . "\r\n";

		return $return;
	}

	private function http_build_cookies($cookies)
	{
		$return = '';

		foreach($cookies as $name => $value)
			$return .= ' ' . $name . '=' . $value . ';';

		return trim($return);
	}
}

?>