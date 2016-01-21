(function() {
    'use strict';

    angular.module('app', [
      'ngResource',
      'ngRoute',
      'ngMessages',
      'smart-table',
      'ui.bootstrap',
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
                              return 'index.html';
                            },
                controller:  'Home',
                controllerAs :'mv'
             }).
        otherwise({redirectTo:  '/home/'});
  }]);


})();
