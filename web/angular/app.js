var config = {
    basePath: '../angular/',
    restServer: '../index.php/api'
};

var zcpe = angular.module('zcpe', [
    'ngRoute',
    'pascalprecht.translate',
    'ngStorage',
    'controllers-quizz',
    'btford.markdown',
    'hljs',
    'timer'
]);

zcpe.controller('SessionsCtrl', ['$scope', '$location', '$http', function ($scope, $location, $http) {
    $scope.goToStartPage = function () {
        $location.path('/new');
    };
    
    $http.get(config.restServer+'/sessions').success(function (data) {
        $scope.sessions = data.sessions;
    });
}]);

zcpe.controller('StartPageCtrl', ['$scope', '$location', '$http', '$localStorage', function ($scope, $location, $http, $localStorage) {
    $scope.introTemplate = config.basePath + 'partials/intro.fr.html';
    $scope.startDisabled = false;
    
    $scope.start = function () {
        $scope.startDisabled = true;
        
        $http.post(config.restServer+'/session').success(function (data) {
            $localStorage.sessionData = data;
            $location.path('/quiz');
        });
    };
}]);

zcpe.controller('QuizCtrl', ['$scope', '$location', '$http', '$localStorage', '$controller', function ($scope, $location, $http, $localStorage, $controller) {
    var sessionData = $localStorage.sessionData;
    
    $controller('QuizzCtrl', {$scope: $scope});
    
    $scope.finish = function () {
        $scope.currentQuestion = null;
        $scope.finished = true;
        
        var score = Evaluator.evaluate($scope.quizz);
        
        $http({
            url: config.restServer + '/session/finish/' + sessionData.id,
            method: 'POST',
            data: score
        });
        
        $localStorage.score = score;
        $localStorage.sessionData = null;
        
        $location.path('/result');
    };
    
    $scope.timerFinished = function () {
        $scope.finish();
    };
    
    $scope.init(createQuiz(sessionData));
    $scope.start();
}]);

zcpe.controller('ResultCtrl', ['$scope', '$location', '$http', '$localStorage', '$controller', function ($scope, $location, $http, $localStorage, $controller) {
    var quizz = $localStorage.quizz;
    
    $controller('QuizzCtrl', {$scope: $scope});
    
    $scope.init(quizz);
    $scope.finish();
    $scope.score = $localStorage.score;
}]);

/**
 * Override timer directive to add an extra parameter
 */
zcpe.config(function($provide) {
    $provide.decorator('timerDirective', function($delegate) {
        var directive = $delegate[0];
        angular.extend(directive.scope, {
            quizMaxTime:'='
        });
        return $delegate;
    });
});

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

/**
 * Translations
 */
zcpe.config(['$translateProvider', function ($translateProvider) {
    $translateProvider.translations('fr', {
        'about': 'À propos',
        'all.es': 'Toutes',
        'back.to.sessions': 'Retourner à l\'écran des sessions',
        'create.account': 'Créer un compte',
        'correct.answer': 'Solution',
        'errors.only': 'Erreurs seulement',
        'finish': 'Terminer',
        'home': 'Accueil',
        'log.in': 'Se connecter',
        'log.out': 'Se déconnecter',
        'my.account': 'Mon compte',
        'my.sessions': 'Mes sessions',
        'new.session': 'Nouvelle session',
        'next': 'Suivant',
        'on.date.at.time': 'Le {{date}} à {{time}}',
        'previous': 'Précédent',
        'result': 'Résultat',
        'start.quiz': 'Démarrer le Questionnaire',
        'topics.validated': 'Topics validés',
        'your.score': 'Votre score',
        'your.answer': 'Votre Réponse'
    });
    $translateProvider.translations('en', {
        home: 'Home'
    });
    $translateProvider.preferredLanguage('fr');
}]);
