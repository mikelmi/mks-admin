(function(){

    var app = angular.module('admin', [
        'ngCookies',
        'ngSanitize',
        'ngRoute',
        'ngToast',
        'layout'
    ]);

    //Service for building correct urls
    app.provider('Url', [function() {
        var baseUrl = (jQuery('base').prop('href')) . replace(/\/$/g, '');

        function getUrl(path) {
            if (!path) {
                return baseUrl;
            }

            if (/^https?\:\/\//.test(path)) {
                return path;
            }

            return baseUrl + '/' + path.replace(/\/$/g, '');
        };

        return {
            setBaseUrl: function(base) {
                baseUrl = base;
            },
            getByRoute: function(route) {
                return getUrl(route.path);
            },
            $get: function() {
                return {
                    base: baseUrl,
                    get: getUrl
                }
            }
        };
    }]);

    app.factory('adminHttpInterceptor', ['$q', 'ngToast', '$rootScope', function($q, ngToast, $rootScope) {
        return {
            request: function(config) {
                config.headers['X-Requested-With'] = 'XMLHttpRequest';

                return config;
            },

            responseError: function(response) {
                var message = response.status + '. ' + response.statusText;
                var url = response.config.url;

                $rootScope.errorUrl = url;

                if (response.config.method == "GET") {
                    var href = /^https?\:\/\/.+/.test(url) ? url : '#' + url;
                    url = '<a href="'+href+'">' + url + '</a>';
                }

                message = '<strong>' + message + '</strong><p>' + url + '</p>';

                ngToast.create({
                    className: 'danger',
                    content: message,
                    dismissOnTimeout: false,
                    dismissOnClick: false,
                    dismissButton: true
                });

                $rootScope.errorStatus = response.status;

                return $q.reject(response);
            }
        };
    }]);

    app.config(["$interpolateProvider", "$httpProvider", "$routeProvider", 'UrlProvider',
        function ($interpolateProvider, $httpProvider, $routeProvider, UrlProvider) {
            $interpolateProvider.startSymbol('{[{');
            $interpolateProvider.endSymbol('}]}');

            $httpProvider.interceptors.push('adminHttpInterceptor');

            $routeProvider.when('/404', {
                template: function () {
                    return '<div class="page-content"><div class="card shd"><div class="card-block">Page Not Found</div></div></div>';
                }
            }).when('/error', {
                template: function () {
                    return '<div class="page-content"><div class="card shd"><div class="card-block">An Error Occurred</div></div></div>';
                }
            }).when('/:path*', {
                templateUrl: UrlProvider.getByRoute,
                controller: 'PageCtrl'
            }).otherwise({
                redirectTo: '/home'
            });
        }
    ]);

    app.run(['$rootScope', '$location', '$templateCache', '$cookies',
        function ($rootScope, $location, $templateCache, $cookies) {
            jQuery.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $cookies.get('XSRF-TOKEN'),
                    'Accept': "application/json, text/plain, */*"
                }
            });

            $rootScope.$on('$routeChangeStart', function(event, next, current) {
                //prevent route template caching
                if (typeof(current) !== 'undefined' && typeof current.loadedTemplateUrl == 'string'){
                    $templateCache.remove(current.loadedTemplateUrl);
                }
            });

            $rootScope.$on('$routeChangeError', function (event) {
                if (event.targetScope && event.targetScope.errorStatus && event.targetScope.errorStatus == 404) {
                    $location.path('/404');
                } else {
                    $location.path('/error');
                }
            });

            $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
                $rootScope.currentPath = $location.path();
            });
        }]);

})(window.angular);