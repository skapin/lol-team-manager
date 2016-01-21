(function() {
    'use strict';

    angular
        .module('utils.storage')
        .service('storage', storage );

    function storage()
    {
      var store = {};

       var addItem = function(newObj, key)
       {
           store[key] = newObj;
       };

       var getItem = function(key)
       {
           return angular.copy(store[key]);
       };

       var getItemRef = function(key)
       {
           return store[key];
       };

       var clear = function(key)
       {
           delete store[key];
       };

       return {
         addItem: addItem,
         getItem: getItem,
         getItemRef: getItemRef,
         clear: clear
       };
    }
})();