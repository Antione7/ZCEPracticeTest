/**
 * Translations
 */
zcpe.config(['$translateProvider', function ($translateProvider) {
    $translateProvider.translations('fr_FR', {
        '_.minutes': 'minutes',
        '_.remaining.minutes': 'minutes restantes',
        'about': 'À propos',
        'all.es': 'Toutes',
        'back.to.sessions': 'Retourner à l\'écran des sessions',
        'create.account': 'Créer un compte',
        'creating.quiz': 'Génération du questionnaire...',
        'continue.current.session': 'Continuer la session en cours',
        'current.session': 'Session en cours',
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
    	'_.minutes': 'minutes',
        '_.remaining.minutes': 'remaining minutes',
        'about': 'About',
        'all.es': 'All',
        'back.to.sessions': 'Back to sessions',
        'create.account': 'Create an account',
        'creating.quiz': 'Quiz generation...',
        'continue.current.session': 'Continuer la session en cours',
        'current.session': 'Current session',
        'duration': 'Duration',
        'errors.only': 'Errors only',
        'expected.answer': 'Expected answer',
        'finish': 'Finish',
        'home': 'Home',
        'incorrect.answers': 'Wrongs answers',
        'log.in': 'Login',
        'log.out': 'Logout',
        'my.account': 'My account',
        'my.panel': 'My panel',
        'my.sessions': 'My sessions',
        'need.credit': 'You have no more credits',
        'new.session': 'New session',
        'next': 'Next',
        'on.date.at.time': 'On {{date}} at {{time}}',
        'passed.at': 'Passed',
        'previous': 'Previous',
        'result': 'Result',
        'session': 'Session',
        'start.quiz': 'Start the quiz',
        'topics.validated': 'Validated topics',
        'your.score': 'Your score',
        'your.answer': 'Your answer',
        'session.new.intro': ''
    });

    $translateProvider.translations('pt_BR', {
    	'_.minutes': 'minutos',
        '_.remaining.minutes': 'minutos restantes',
        'about': 'Sobre',
        'all.es': 'Todas',
        'back.to.sessions': 'Voltar na tela das sessões',
        'create.account': 'Criar uma conta',
        'creating.quiz': 'Geração do questionário...',
        'continue.current.session': 'Continuer la session en cours',
        'current.session': 'Sessão corrente',
        'duration': 'Duração',
        'errors.only': 'Erros somente',
        'expected.answer': 'Resposta esperada',
        'finish': 'Concluír',
        'home': 'Início',
        'incorrect.answers': 'Respostas erradas',
        'log.in': 'Login',
        'log.out': 'Logout',
        'my.account': 'Minha conta',
        'my.panel': 'Meu painel',
        'my.sessions': 'Minhas sessões',
        'need.credit': 'Você não tem mais créditos',
        'new.session': 'Nova sessão',
        'next': 'Seguinte',
        'on.date.at.time': '{{date}} as {{time}}',
        'passed.at': 'Passada dia',
        'previous': 'Anterior',
        'result': 'Resultado',
        'session': 'Sessão',
        'start.quiz': 'Iniciar o questionário',
        'topics.validated': 'Tópicos validados',
        'your.score': 'Sua nota',
        'your.answer': 'Sua resposta',
        'session.new.intro': ''
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