(function() {
    'use strict';

    angular
        .module('utils.display')
        .factory('display', display );

    display.$inject = ['$modal'];

    function display( $modal)
    {
        var factory =
        {
            displayContentModal: displayContentModal
        };
        return factory;

        ////////////////////////////////////////////////////////////


        function CloseModal($scope, $sce, $modalInstance, title, content, is_html)
        {
            $scope.title   = title;
            $scope.content = content;

            if ( typeof(is_html) !== 'undefined' && is_html )
                $scope.content = $sce.trustAsHtml(content);
            else
                $scope.content = content;
            $scope.close   = function()
            {
                $modalInstance.close();
            };
        }

        function displayContentModal(title, content, is_html, size)
        {
            if ( typeof(size) == 'undefined')
            {
                size = 'md';
            }
            var dialogOpts = {
                            backdrop: true,
                            keyboard: true,
                            templateUrl: 'partials/display/content.html',
                            size: size,
                            controller: ['$scope', '$sce', '$modalInstance', 'title', 'content', 'is_html', CloseModal],
                            resolve: {
                                title: function()
                                {
                                    return title;
                                },
                                content: function()
                                {
                                    return content;
                                },
                                is_html: function()
                                {
                                    return is_html;
                                }
                            }
                        };
            return $modal.open(dialogOpts).result;
        }
    }
})();