/**
 * Translations
 */
zcpe.config(['$translateProvider', function ($translateProvider) {
    $translateProvider.translations('fr_FR', {
        '_.minutes': 'minutes',
        'about': 'À propos',
        'all.es': 'Toutes',
        'back.to.sessions': 'Retourner à l\'écran des sessions',
        'create.account': 'Créer un compte',
        'creating.quiz': 'Génération du questionnaire...',
        'correct.answer': 'Solution',
        'duration': 'Durée',
        'errors.only': 'Erreurs seulement',
        'expected.answer': 'Réponse attendue',
        'finish': 'Terminer',
        'home': 'Accueil',
        'incorrect.answers': 'Réponses incorrectes',
        'log.in': 'Se connecter',
        'log.out': 'Se déconnecter',
        'my.account': 'Mon compte',
        'my.panel': 'Mon tableau de bord',
        'my.sessions': 'Mes sessions',
        'need.credit': 'Vous n\'avez plus de crédits',
        'new.session': 'Nouvelle session',
        'next': 'Suivant',
        'on.date.at.time': 'Le {{date}} à {{time}}',
        'passed.at': 'Passée le',
        'previous': 'Précédent',
        'result': 'Résultat',
        'session': 'Session',
        'start.quiz': 'Démarrer le questionnaire',
        'topics.validated': 'Topics validés',
        'your.score': 'Votre score',
        'your.answer': 'Votre réponse',
        'session.new.intro': 'Oui alors écoute moi, si vraiment tu veux te rappeler des souvenirs de ton perroquet, c\'est juste une question d\'awareness puisque the final conclusion of the spirit is perfection. Tu vas te dire : J\'aurais jamais cru que le karaté guy pouvait parler comme ça !'
    });

    $translateProvider.translations('en_EN', {
        'home': 'Home',
        'my.panel': 'My panel',
        'my.sessions': 'My sessions',
        'about': 'About',
    });

    $translateProvider.translations('pt_BR', {
        'home': 'Início',
        'my.sessions': 'Minhas sessões',
        'my.panel': 'Meu painel',
        'about': 'Sobre',
    });

    $translateProvider.preferredLanguage('en_EN');
    $translateProvider.useLocalStorage();
}]);

zcpe.controller('TranslateCtrl', ['$translate', '$scope', function($translate, $scope) {
    $scope.changeLang = function (langKey) {
	    if (langKey === 'fr_FR' || langKey === 'pt_BR') {
            $translate.use(langKey);
        } else {
            $translate.use('en_EN');
        }
    };
}]);