(function() {
    'use strict';

    angular
        .module('utils.network')
        .factory('network', network );

    network.$inject = [ '$injector',
                        '$timeout',
                        '$interval' ];


    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-center",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "10000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
    function network($injector, $timeout, $interval)
    {
      var enableNotify = true;
        var factory =
        {
            isValideIp : isValideIp,
            isValideCidr : isValideCidr,
            fetch      : fetch,
            get        : get,
            post       : post,
            patch      : patch,
            post_and_watch: post_and_watch,
            addSubnet  : addSubnet,
            enableNotify : enableNotify
        };
        return factory;

        ////////////////
        function enableNotify(enabled)
        {
          enableNotify = enabled;
        }
        function addSubnet(addr)
        {
          if ( typeof(addr) === 'undefined' )
            return '';
          if ( addr.indexOf('/') > -1 )
            return addr;
          else
          {
            return addr+'/32';
          }
        }
        function isValideIp(elem)
        {
          var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\/(3[0-2]|[0-2]?[0-9]))?$/;
          if ( elem.match(ipformat))
          {
            var elem_sub = addSubnet(elem);
            return isValideCidr(elem_sub)
          }
          return false;
        }
        function isValideCidr(elem)
        {
          var cidr_section;
          var c_mask;
          var bin_mask;
          var mask     = elem.split('/');
          var sections = mask[0].split('.');
          mask         = mask[1];

          if ( sections.length != 4)
            return false;

          for ( var i = 0; i < 4 ; i++)
          {
            bin_mask = mask;
            if ( bin_mask > 8 )
              bin_mask = 8
            c_mask = (( 0xffff >> (8 - bin_mask)) << (8 - bin_mask)) & 255;
            cidr_section = ( c_mask & sections[i]);
            if ( cidr_section != sections[i])
            {
              return false;
            }
            mask -= 8;
            if ( mask < 0 )
            {
              mask = 0;
            }
          }
          return true;

          var cird_format = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(\/([0-9]|[1-2][0-9]|3[0-2]))$/;
          return elem.match(cird_format);
        }
        function post_and_watch( post_api, post_param, watch_api, waiting_message, success_message, error_message)
        {
          if (typeof(waiting_message)==='undefined') waiting_message = "Data being processed";
          if (typeof(success_message)==='undefined') success_message = "Done";
          if (typeof(error_message)==='undefined') error_message = "Error";

          var refresh_timeout  = 1000;
          var max_refresh_iter = 120;
          var max_waiting_time = (refresh_timeout*max_refresh_iter)
          var deferred = $injector.get('$q').defer();

          if ( enableNotify ) toastr.info(waiting_message, "Processing", {timeOut: max_waiting_time});

          factory.post( post_param, post_api).then(function ( return_val )
          {
              var refresh_iter = 0;
              var req_uuid = return_val.results;
              if ( req_uuid == "0" )
              {
                toastr.remove();
                toastr.success(success_message, "Job Done !", {timeOut: 15000});
                deferred.resolve("Done");
                return;
              }
              var check_interval = $interval(function()
                          {
                              if ( enableNotify ) toastr.info(waiting_message, "Processing...", {timeOut: max_waiting_time});
                              factory.get( {uuid: req_uuid}, watch_api).then(
                                function ( return_val )
                                {
                                    refresh_iter +=1
                                    if ( refresh_iter > max_refresh_iter )
                                    {
                                        if ( enableNotify )
                                        {
                                          toastr.remove();
                                          toastr.warning("I'm waiting for too long...", "Ups !", {timeOut: 15000});
                                        }
                                        $interval.cancel(check_interval);
                                        deferred.reject();
                                    }
                                    if ( ! jQuery.isEmptyObject(return_val.results))
                                    {
                                        if ( enableNotify )
                                        {
                                          toastr.remove();
                                          toastr.success(success_message, "Job Done !", {timeOut: 15000});
                                        }
                                        $interval.cancel(check_interval);
                                        deferred.resolve(return_val.results);
                                    }
                                },
                                function (data)
                                {
                                  if ( enableNotify )
                                  {
                                    toastr.remove();
                                    toastr.error("An error happended...<br>"+data.message+" <br><strong>Code: "+data.code+"</strong>", "Wow !", {timeOut: 5000});
                                  }
                                  $interval.cancel(check_interval);
                                  deferred.reject(data);
                                });
                          }, refresh_timeout);
          }, function(data)
            {
              deferred.reject(data);
            }
          );
          return deferred.promise;
        }
        function fetch(options, file)
        {
            return $timeout(function()
            {
              var $http    = $injector.get('$http');
              var deferred = $injector.get('$q').defer();
              $http.get(file)
                   .success(
                     function (data)
                     {
                       deferred.resolve({
                         results: data,
                         total:   data.length
                       });
                     })
                   .error(
                     function (data, xstatus)
                     {
                        if ( enableNotify ) toastr.error(data.message, xstatus);
                        deferred.reject();
                     });

              return deferred.promise;
            }, 30);
        }
        function get(options, file)
        {
            return $timeout(function()
            {
              var $http    = $injector.get('$http');
              var deferred = $injector.get('$q').defer();
              $http.get(file,
                        {'params': options})
                   .success(
                     function (data)
                     {
                       deferred.resolve({
                         results: data
                       });
                     })
                   .error(
                     function (data, xstatus)
                     {
                        if ( enableNotify ) toastr.error(data.message, xstatus);
                        deferred.reject(data);
                     });

              return deferred.promise;
            }, 30);
        }
        function post(options, file)
        {
            return $timeout(function()
            {
              var $http    = $injector.get('$http');
              var deferred = $injector.get('$q').defer();
              $http.post(file, options)
                   .success(
                     function (data)
                     {
                       deferred.resolve({
                         results: data
                       });
                     })
                   .error(
                     function (data, xstatus)
                     {
                        if ( enableNotify )
                        {
                          toastr.remove();
                          toastr.error(data.message, xstatus);
                        }
                        deferred.reject(data);
                     });

              return deferred.promise;
            }, 30);
        }
        function patch(options, file)
        {
            return $timeout(function()
            {
              var $http    = $injector.get('$http');
              var deferred = $injector.get('$q').defer();
              $http.patch(file, options)
                   .success(
                     function (data)
                     {
                       deferred.resolve({
                         results: data
                       });
                     })
                   .error(
                     function (data, xstatus)
                     {
                        if ( enableNotify ) toastr.error(data.message, xstatus);
                        deferred.reject();
                     });

              return deferred.promise;
            }, 30);
        }
    }
})();