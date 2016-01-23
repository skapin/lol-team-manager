(function() {
    'use strict';

    angular.module('app', [
      'ngResource',
      'ngRoute',
      'ngMessages',
      'utils.network',
      'smart-table',
      'ui.bootstrap',
      'lol',
      'frapontillo.bootstrap-switch',
      'ngSanitize'
    ]);


    /*
     * CONTROLLERS
     */


    function navbar($scope, $location)
    {
      $scope.isActive = function (route)
      {
        return $location.path().indexOf(route) === 0;
      }
    }
     angular
         .module('app')
         .controller('navbar', navbar);

     angular
         .module('app')
         .controller('home', home);


    function home($scope, $location, network)
    {
      
    }


    navbar.$inject = ['$scope','$location'];
    /*
    * ROUTES
    */
    angular
    .module('app')
    .config(['$routeProvider', '$injector',
    function($routeProvider, $injector)
    {
      $routeProvider.
        when('/home/',
             {
                templateUrl: function (params)
                            {
                              return 'welcome.html';
                            },
                controller:  'home',
                controllerAs :'mv'
             }).
        otherwise({redirectTo:  '/home/'});
  }]);


})();
