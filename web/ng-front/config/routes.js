/**
 * Routes
 */
zcpe.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: config.basePath + 'templates/sessions.html',
            controller: 'SessionsCtrl'
        })
        .when('/session/:sessionId', {
            templateUrl: config.basePath + 'templates/session.html',
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
        .when('/new', {
            templateUrl: config.basePath + 'templates/new.html',
            controller: 'StartPageCtrl'
        })
        .when('/quiz', {
            templateUrl: config.basePath + 'templates/quiz.html',
            controller: 'QuizCtrl'
        })
        .when('/result', {
            templateUrl: config.basePath + 'templates/result.html',
            controller: 'ResultCtrl'
        })
    ;
}]);
