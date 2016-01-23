(function() {
    'use strict';

    angular
        .module('lol')
        .factory('lol', lol );

    lol.$inject = [ '$injector',
                        '$timeout',
                        '$interval' ];

    function lol($injector, $timeout, $interval)
    {
      var enableNotify = true;
        var factory =
        {
            getTeamByUser : getTeamByUser,
            
        };
        return factory;

        ////////////////
        function getTeamByUser(enabled)
        {
          return '1';
        }
    }
})();