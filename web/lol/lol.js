(function() {
    'use strict';

    angular
        .module('lol')
        .factory('lol', lol );

    lol.$inject = [ 'network' ];

    function lol(network)
    {
      var enableNotify = true;

        var factory =
        {
            getTeamByUser : getTeamByUser,
            getSummonerByName: getSummonerByName,
            getSummonerChampionList: getSummonerChampionList

        };
        return factory;

        ////////////////
        function getTeamByUser(enabled)
        {
          return '1';
        }
        function getSummonerByName(name)
        {
          var params  = { 'ACTION': 'get_lol_user_info',
                          'pseudo': name };;
          return network.get(params, '/lol/API/APIRouting.php');
        }
        function getSummonerChampionList(name)
        {
          var params  = { 'ACTION': 'get_my_champion_list' };
          return network.get(params, '/lol/API/APIRouting.php');
        }
    }
})();