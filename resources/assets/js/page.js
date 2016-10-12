(function(){

    var app = angular.module('page', ['ngToast']);

    app.factory('Page', ['$location', '$route', '$templateCache', '$timeout', 'ngToast', 'UrlBuilder', '$rootScope',
        function($location, $route, $templateCache, $timeout, ngToast, UrlBuilder, $rootScope) {

            this.currentPath = $location.path();
            this.isLoading = false;

            this.reload = function () {
                var tmpl = $route.current.loadedTemplateUrl;

                if (tmpl) {
                    $templateCache.remove(tmpl);
                }

                $route.reload();
            };

            this.goTo = function(url) {
                if (url == $route.current.loadedTemplateUrl || url == $location.url()) {
                    this.reload();
                    return;
                }

                $location.url(url);
            };

            this.processResponseHeaders = function(xhr, requestUrl) {
                var url,
                    path,
                    getHeader,
                    message,
                    messageType,
                    status = xhr.status,
                    statusText = xhr.statusText;

                if (typeof xhr.getResponseHeader == 'function') {
                    getHeader = 'getResponseHeader';
                } else if(typeof xhr.headers == 'function') {
                    getHeader = 'headers';
                } else {
                    return false;
                }

                message = xhr[getHeader].call(xhr, 'X-Flash-Message');

                if (message) {
                    messageType = xhr[getHeader].call(xhr, 'X-Flash-Message-Type') || 'info';
                    $timeout(function () {
                        ngToast.create({
                            className: messageType,
                            content: decodeURIComponent(message),
                            dismissButton: true
                        });
                    });
                }

                var model_data = xhr[getHeader].call(xhr, 'X-Model-Data');
                if (model_data) {
                    try {
                        model_data = angular.fromJson(model_data);
                        $timeout(function () {
                            var scope = angular.element('[ng-view]').scope();
                            if (scope) {
                                if (typeof scope.page != 'undefined') {
                                    scope.page.model = model_data;
                                } else {
                                    scope.model = model_data;
                                }
                            }
                        });
                    } catch (err) {}
                }

                if (status == 301 || status == 302 || status == 401 || status == 402 || status == 403) {
                    url = xhr[getHeader].call(xhr, 'X-Redirect-Url');
                    if (!url) {
                        path = xhr[getHeader].call(xhr, 'X-Redirect-Path');
                        if (path) {
                            var self = this;
                            $timeout(function () {
                                self.goTo(path);
                            });
                            return true;
                        }
                    } else {
                        document.location.href = url;
                        return true;
                    }
                } else if(status > 200) {
                    message = '<strong>' + status + '. ' + statusText + '</strong>';
                    if (requestUrl) {
                        message += '<p><a href="' + UrlBuilder.path(requestUrl) + '">' + UrlBuilder.path(requestUrl) + '</p>';
                    }
                    $timeout(function () {
                        ngToast.create({
                            className: 'danger',
                            content: message,
                            dismissButton: true
                        });
                    });
                }
            };

            this.updateCurrentPath = function() {
                this.currentPath = $location.path();
            };

            this.isCurrentPath = function(path) {
                if (typeof this.currentPath == 'string') {
                    var i = this.currentPath.indexOf(path);
                    return i === 0 || i === 1;
                }

                return false;
            };

            this.setLoading = function(loading, defer) {
                if (defer) {
                    var self = this;
                    $timeout(function () {
                        self.setLoading(loading, false);
                    });

                    return;
                }

                this.isLoading = $rootScope.pageLoading = loading||false;
            };

            return this;
        }
    ]);

    app.controller('PageCtrl', [function() {

    }]);

    //submit button (for mks-form)
    app.directive("mksSubmit", function() {
        return {
            restrict: 'A',
            link: function(scope, element, attr) {
                element.on('click', function (e) {
                    e.preventDefault();
                    var $form = attr.mksSubmit ? jQuery(attr.mksSubmit) : jQuery('form[mks-form]:first');
                    scope.submitFlag = element.data('flag');
                    $form.submit();
                });
            }
        }
    });

    //jquery ajax form
    app.directive("mksForm", ['$location','Page', function($location, Page) {
        return {
            restrict: 'A',
            link: function(scope, form, attr) {
                var ctrl = scope.page || scope;
                var opt = {
                    cache: false,
                    beforeSerialize: function () {
                        if (typeof CKEDITOR != 'undefined') {
                            for (var instance in CKEDITOR.instances) {
                                CKEDITOR.instances[instance].updateElement();
                            }
                        }
                    },
                    beforeSend: function(xhr) {
                        var xhr_old = form.data('jqxhr');
                        if (xhr_old) {
                            xhr_old.abort();
                        }

                        Page.setLoading(true, true);

                        xhr.setRequestHeader('X-Submit-Flag', scope.submitFlag);
                    },
                    error: function(xhr, status) {
                        if (xhr.status == 422 && xhr.responseJSON) {
                            ctrl.errors = xhr.responseJSON;
                        }

                        if (xhr.status >= 402) {
                            ctrl.errorStatus = xhr.status;
                            ctrl.errorText = xhr.statusText;

                            if (!scope.$$phase) {
                                scope.$apply();
                            }
                        }
                    },
                    complete: function(xhr) {
                        Page.setLoading(false, true);
                        Page.processResponseHeaders(xhr);
                    }
                };
                form.ajaxForm(opt);
            }
        }
    }]);

})(window.angular);
