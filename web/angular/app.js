var zcpe = angular.module('zcpe', ['ngRoute', 'pascalprecht.translate']);

zcpe.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'angular/templates/index.html',
            controller: 'MainCtrl'
        })
        .when('/about', {
            templateUrl: 'angular/templates/about.fr.html',
            controller: 'MainCtrl'
        })
    ;
}]);

zcpe.config(['$translateProvider', function ($translateProvider) {
    $translateProvider.translations('fr', {
        'about': 'À propos',
        'all.es': 'Toutes',
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
        'on.%date%.at.%time%': 'Le %date% à %time%',
        'previous': 'Précédent',
        'start.quiz': 'Démarrer le Questionnaire',
        'topics.validated.%count%': '%count% / 10 Topic validé | %count% / 10 Topics validés',
        'your.score': 'Votre score',
        'your.answer': 'Votre Réponse'
    });
    $translateProvider.translations('en', {
        home: 'Home'
    });
    $translateProvider.preferredLanguage('fr');
}]);


