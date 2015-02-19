/**
 * Translations
 */
zcpe.config(['$translateProvider', function ($translateProvider) {
    $translateProvider.translations('fr', {
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
        'session.new.intro': 'Vous allez démarrer une session de test de la certification ZCPE. Dans les mêmes conditions que l\'épreuve'
        	+ ' officielle, ce test comprend 70 questions, en anglais, et un temps limité de 90 minutes. Une fois le test achevé, un rapport synthétique'
            + ' est généré et vous permet de connaître directement votre réussite par topic et de revenir sur vos réponses erronées.'
    });

    $translateProvider.translations('en', {
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
        'session.new.intro': 'You will start a test session of the ZCPE certification. In the same conditions as the official test,'
        	+ ' this test includes 70 questions in English and a limited time of 90 minutes. A summary report is generated when test is completed,'
            + ' and lets you know your achievement by topic and get back on your incorrect answers.'
    });

    $translateProvider.translations('pt', {
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
        'session.new.intro': 'Você vai começar uma sessão de teste da certificação ZCPE. Nas mesmas condições da prova oficial, esse teste tem'
        	+ ' 70 perguntas, em inglês, e um tempo limitado de 90 minutos. Um relatório sintético é gerado assim que o teste for concluído'
            + ' e permite-lhe de conhecer seu sucesso por tópico e voltar sobre suas respostas erradas.'
    });

    $translateProvider.preferredLanguage(document.documentElement.getAttribute('lang'));
}]);
