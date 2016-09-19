(function(){

    var layout = angular.module('layout', []);

    layout.controller('AppCtrl', ['Page', function(Page) {
        this.leftClosed = window.innerWidth < 768;

        this.refresh = function(e) {
            if (e) {
                e.preventDefault();
            }

            Page.reload();

            return false;
        };

        this.isCurrentPath = function(path) {
            return Page.isCurrentPath(path);
        };
    }]);

    layout.controller('MenuCtrl', ['$http', 'UrlBuilder', function($http, UrlBuilder) {
        this.items = [];

        var self = this;

        $http.get(UrlBuilder.get('menu')).then(function(r) {
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

    if (!window.materialized) {
        //apply custom checkboxes and radios
        layout.directive('formCheckInput', [function () {
            return {
                restrict: 'C',
                link: function (scope, elem, attr) {
                    var label = elem.parent('label');

                    label.addClass('custom-control ' + (elem.is(':radio') ? 'custom-radio' : 'custom-checkbox'));

                    elem.addClass('custom-control-input')
                        .after('<span class="custom-control-indicator"></span>');
                }
            }
        }]);
    } else {
        //set active label on focus
        layout.directive('formControl', [function () {
            return {
                restrict: 'C',
                link: function (scope, elem, attr) {
                    var label = elem.closest('.form-group').children('label');
                    elem.on('focus', function(){
                        label.addClass('active');
                    }).on('blur', function() {
                        label.removeClass('active');
                    });
                }
            }
        }]);
    }

})(window.angular);
