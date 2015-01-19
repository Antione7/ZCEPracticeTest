/**
 * Translations
 */
zcpe.config(['$translateProvider', function ($translateProvider) {
    $translateProvider.translations('fr', {
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
        'your.answer': 'Votre réponse'
    });
    $translateProvider.translations('en', {
        home: 'Home'
    });
    $translateProvider.preferredLanguage('fr');
}]);
