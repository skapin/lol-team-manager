<?php
require_once ('include.php');


class LOL
{
	var $base_url = 'https://euw.api.pvp.net';
	var $global_url = 'https://global.api.pvp.net';
	var $ddragon_url = 'http://ddragon.leagueoflegends.com/cdn/';
	var $ddragon_version = null;
	var $url_champ_icon ='/img/champion/';

	var $region = 'euw';

	function getAPIKey()
	{
		return $GLOBALS['LOL_API_KEY'];
	}
	function getDDragonVersion()
	{
		if ( $self->ddragon_version == null)
		{
			$version_obj = json_decode(CallAPI('GET', $this->global_url.'/api/lol/static-data/'.$this->region.'/v1.2/versions'.$this->apiKeyAsParam() ));
			$self->ddragon_version = $version_obj[0];
		}
		return $self->ddragon_version;
	}

	function getTeamByUserId($id)
	{
		return CallAPI('GET', $this->base_url.'/api/lol/'.$this->region.'/v2.4/team/by-summoner/'.$id.$this->apiKeyAsParam());
	}

	function getUserByName($name)
	{
		return CallAPI('GET', $this->base_url.'/api/lol/'.$this->region.'/v1.4/summoner/by-name/'.$name.$this->apiKeyAsParam() );
	}

	function getAllChamp()
	{
		return CallAPI('GET', $this->global_url.'/api/lol/static-data/'.$this->region.'/v1.2/champion'.$this->apiKeyAsParam() );
	}

	function apiKeyAsParam()
	{
		return '?api_key='.$this->getAPIKey();
	}
	function getSummonerInfo($pseudo)
	{
		$ret = CallAPI('GET', $this->base_url.'/api/lol/'.$this->region.'/v1.4/summoner/by-name/'.$pseudo.$this->apiKeyAsParam() );

		return $ret;
	}

}

$l = new Lol();
print($l->getUserByName('skapin'));
print($l->getDDragonVersion());

?>
