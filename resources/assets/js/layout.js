(function(){

    var layout = angular.module('layout', []);

    layout.controller('AppCtrl', [function() {
        this.leftClosed = window.innerWidth < 768;
    }]);

    layout.controller('MenuCtrl', ['$http', 'Url', function($http, Url) {
        this.items = [];

        var self = this;

        $http.get(Url.get('menu')).then(function(r) {
            angular.forEach(r.data, function(item) {
                if (item.title && item.title.length) {
                    item.firstChar = item.title.charAt(0).toUpperCase();
                }
            });

            self.items = r.data;
        });

        this.toggle = function(item, event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            angular.forEach(this.items, function(i) {
                if (i != item) {
                    i.expanded = false;
                }
            });

            item.expanded = !item.expanded;

            return false;
        };
    }]);

    layout.controller('PageCtrl', [function() {

    }]);

    //prevent location change after click on anchor elements
    layout.directive('a', [function () {
        return {
            restrict: 'E',
            link: function(scope, elem, attrs) {
                if (attrs.toggle || attrs.href === "#"){
                    elem.on('click', function(e){
                        e.preventDefault();
                    });
                }
            }
        };
    }]);

})(window.angular);
