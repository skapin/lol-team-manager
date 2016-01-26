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
      'app.authentificator',
      'app.home',
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
        when('/register/',
             {
                templateUrl: function (params)
                            {
                              return 'authentificator/register.html';
                            },
                controller:  'Register',
                controllerAs :'mv'
             }).
        otherwise({redirectTo:  '/home/'});
  }]);


})();
