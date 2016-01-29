(function() {
  'use strict';


   angular
       .module('app.authentificator')
       .controller('Register', Register);

  Register.$inject = [ '$scope', '$location', 'lol' ];

  function Register($scope, $location, lol)
  {
    var mv                     = this;
    mv.password                = '';
    mv.password_confirmation   = '';
    mv.summoner_name           = '';
    mv.datas_checked           = false;
    mv.searching_summoner_name = false;
    mv.summoner                = false;

    $scope.$watchGroup(['mv.password', 'mv.password_confirmation'], watchPassword);

    function watchPassword(newValues, oldValues, scope)
    {
      if ( (newValues[0] === '' && newValues[1] === '') || (typeof(newValues[0])==='undefined' && typeof(newValues[1])==='undefined') )
      {
          mv.confirm = {'hint':'',
                        'glyph':'glyphicon-warning-sign',
                        'has_feedback':'has-warning'};

      }
      else if ( newValues[0] == newValues[1])
      {
          mv.confirm = {'hint':'Okay!',
                        'glyph':'glyphicon-ok',
                        'has_feedback':'has-success'};
      }
      else
      {
          mv.confirm = {'hint':"Error, passwords are different",
                        'glyph':'glyphicon-remove',
                        'has_feedback':'has-error'};
      }

    };
    mv.create_summoner = function()
    {
      var params = {'register':'yes',
                    'pseudo': mv.summoner_name,
                    'password': mv.password,
                    'password_confirmation': mv.password_confirmation};
      lol.createSummonerAccount(params).then(
        function()
        {});
    };
    mv.search_summoner_name = function()
    {
      var summoner_name = mv.summoner_name;
      mv.searching_summoner_name = true;

      lol.getSummonerByName(summoner_name).then(
          function ( summoner_data )
          {
            if ( summoner_data )
            {
              mv.summoner                = summoner_data[summoner_name];
              mv.searching_summoner_name = false;
              mv.datas_checked           = true;
            }
            else
            {
              mv.searching_summoner_name = false;
            }
          });
    };

  }


})();