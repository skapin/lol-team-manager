(function() {
    'use strict';


     angular
         .module('app.home')
         .controller('home', home);


    function home($scope, $location, network)
    {
      var mv = this;

      mv.click = function()
      {
        var params  = { 'ACTION': 'get_lol_user_info',
                        'pseudo': name };;
        return network.get(params, '/lol/API/APIRouting.php');
      }
    }


})();