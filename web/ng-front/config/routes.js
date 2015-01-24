/**
 * Routes
 */
zcpe.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: config.basePath + 'templates/panel.html',
            controller: 'PanelCtrl'
        })
        .when('/session/:sessionId', {
            templateUrl: config.basePath + 'templates/session-detail.html',
            controller: 'SessionCtrl',
            resolve: {
                sessionId: function ($q, $route) {
                    var deferred = $q.defer();
                    var id = $route.current.params.sessionId;

                    if ((id == parseInt(id, 10)) && (id > 0)) {
                        deferred.resolve(id);
                    } else {
                        deferred.reject('sessionId is not a positive integer');
                    }

                    return deferred.promise;
                }
            }
        })
        .when('/session-new', {
            templateUrl: config.basePath + 'templates/session-new.html',
            controller: 'StartPageCtrl'
        })
        .when('/quiz', {
            templateUrl: config.basePath + 'templates/session-quiz.html',
            controller: 'QuizCtrl'
        })
        .when('/session-result', {
            templateUrl: config.basePath + 'templates/session-result.html',
            controller: 'ResultCtrl'
        })
        .otherwise({
            redirectTo: '/'
        });
    ;
}]);
