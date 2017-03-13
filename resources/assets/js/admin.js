require('./base');
require('angular');
require('angular-sanitize');
require('angular-cookies');
require('angular-route');
require('ng-toast');
require('jquery-form');

require('./layout');
require('./page');
require('./select2');

(function(){

    var modules = [
        'ngCookies',
        'ngSanitize',
        'ngRoute',
        'ngToast',
        'layout',
        'page',
        'select2'
    ];

    if (typeof window.appModules == 'object' && window.appModules.length) {
        modules = modules.concat(window.appModules);
    }

    var app = angular.module('admin', modules);

    app.factory('AppConfig', [function() {
        this.lang = angular.element('html').prop('lang') || 'en';

        this.getLang = function (defaultValue) {
            return this.lang || defaultValue;
        };

        this.setLang = function (lang) {
            this.lang = lang;
        };

        return this;
    }]);

    //Service for building correct urls
    app.provider('UrlBuilder', [function() {
        var baseUrl = (jQuery('base').prop('href')) . replace(/\/$/g, '');

        function getUrl(path) {
            if (!path) {
                return baseUrl;
            }

            if (/^https?\:\/\//.test(path)) {
                return path;
            }

            return baseUrl + '/' + path.replace(/\/$/g, '');
        }

        function getPath(url) {
            if (/^#.+/.test(url) || !baseUrl) {
                return url;
            }

            return url.replace(baseUrl, '#');
        }

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
                    get: getUrl,
                    path: getPath
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

            response: function(response) {
                $rootScope.$emit('response-success', [response, response.config.url]);

                return response;
            },

            responseError: function(response) {
                var url = response.config.url;

                $rootScope.errorUrl = url;
                $rootScope.errorStatus = response.status;

                $rootScope.$emit('response-error', [response, url]);

                return $q.reject(response);
            }
        };
    }]);

    app.config(["$locationProvider", "$httpProvider", "$routeProvider", "$templateRequestProvider", 'UrlBuilderProvider',
        function ($locationProvider, $httpProvider, $routeProvider, $templateRequestProvider, UrlBuilderProvider) {

            $locationProvider.html5Mode(false).hashPrefix('');
            $httpProvider.interceptors.push('adminHttpInterceptor');
            $templateRequestProvider.httpOptions({
                'headers': {
                    'Accept': 'text/html, text/plain, */*'
                }
            });

            $routeProvider.when('/404', {
                template: function () {
                    return '<div class="page-content"><div class="card shd"><div class="card-block">Page Not Found</div></div></div>';
                }
            }).when('/error', {
                template: function () {
                    return '<div class="page-content"><div class="card shd"><div class="card-block">An Error Occurred</div></div></div>';
                }
            }).when('/:path*', {
                templateUrl: UrlBuilderProvider.getByRoute,
                controller: 'PageCtrl',
                controllerAs: 'page'
            }).otherwise({
                redirectTo: '/home'
            });
        }
    ]);

    app.run(['$rootScope', '$location', '$templateCache', '$cookies', 'Page',
        function ($rootScope, $location, $templateCache, $cookies, Page) {
            jQuery.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $cookies.get('XSRF-TOKEN'),
                    'Accept': "application/json, text/plain, */*"
                }
            });

            $rootScope.$on('$routeChangeStart', function(event, next, current) {
                //hide all modals when location changes
                //$('.modal.in').modal('hide');
                $('.modal.in').removeClass('in').hide();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');

                Page.setLoading(true);
                //prevent route template caching
                if (typeof(current) !== 'undefined' && typeof current.loadedTemplateUrl == 'string'){
                    $templateCache.remove(current.loadedTemplateUrl);
                }
            });

            $rootScope.$on('$routeChangeError', function (event) {
                Page.setLoading(false);
                $rootScope.routeError = event.targetScope ? (event.targetScope.errorStatus||500) : 500;
            });

            $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
                Page.setLoading(false);
                $rootScope.routeError = false;
                Page.updateCurrentPath();
            });

            $rootScope.$on('response-success', function(e, data) {
                Page.processResponseHeaders(data[0], data[1]);
            });

            $rootScope.$on('response-error', function(e, data) {
                Page.processResponseHeaders(data[0], data[1]);
            });
        }]);

})(window.angular);