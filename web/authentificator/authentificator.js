(function() {
    'use strict';


     angular
         .module('app.authentificator')
         .controller('Register', Register);


    function Register($scope, $location, network)
    {
      var mv = this;
      mv.password = '';
      mv.password_confirmation = '';
      mv.summoner = '';


      $scope.$watch("mv.summoner", watchSummonerName);
      $scope.$watchGroup(['mv.password', 'mv.password_confirmation'], watchPassword);

      function watchPassword(newValues, oldValues, scope)
      {
        if ( newValues[0] == newValues[1] )
        {
            $scope.form
        }

      };
      function watchSummonerName(newValue, oldValue)
        {
            if ( newValue && newValue.length > 0 )
            {
                mv.traceroute_loading = true;

            }
        }
    }


})();