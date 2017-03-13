require('select2');

(function(){

    var app = angular.module('select2', []);

    app.directive('mksSelect', ['$http', function ($http) {
        return {
            restrict: 'A',
            link: function(scope, elem, attrs) {
                var options = {};
                if (attrs.url) {
                    $http.get(attrs.url).then(function(r) {
                        options.data = r.data;
                        applySelect(elem, options);
                    });

                    return;
                }

                if (attrs.json) {
                    options.data = angular.fromJson(attrs.json)
                } else if(attrs.data) {
                    options.data = attrs.data;
                }

                applySelect(elem, options);
            }
        };
    }]);

    function applySelect(element, options) {
        var opt = {
            theme: 'bootstrap'
        };

        angular.merge(opt, options);

        element.select2(opt);
    }

})(window.angular);
