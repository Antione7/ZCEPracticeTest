/**
 * Routes
 */
zcpe.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: '../angular/templates/sessions.html',
            controller: 'SessionsCtrl'
        })
        .when('/new', {
            templateUrl: '../angular/templates/new.html',
            controller: 'StartPageCtrl'
        })
        .when('/quiz', {
            templateUrl: '../angular/templates/quiz.html',
            controller: 'QuizCtrl'
        })
        .when('/result', {
            templateUrl: '../angular/templates/result.html',
            controller: 'ResultCtrl'
        })
    ;
}]);
