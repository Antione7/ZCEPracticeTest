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
