/**
 * Routes
 */
zcpe.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: config.basePath + 'templates/sessions.html',
            controller: 'SessionsCtrl'
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
