zcpe.controller('QuizCtrl', ['$scope', '$location', '$localStorage', '$controller', 'evaluator', 'quizCreator', 'restApi', 'sessionPersister', function ($scope, $location, $localStorage, $controller, evaluator, quizCreator, restApi, sessionPersister) {
    var sessionData = $localStorage.sessionData;
    
    $controller('QuizzCtrl', {$scope: $scope});
    
    $scope.questionChange = function () {
        sessionPersister.save($scope.quizz, $scope.questionIndex());
    };
    
    var parentFinish = $scope.finish;
    $scope.finish = function () {
        parentFinish();
        
        var score = evaluator.evaluate($scope.quizz);
        
        restApi.postResults(sessionData.id, score);
        restApi.postAnswers(sessionData.id, $scope.quizz.questions.filter(evaluator.isAnswerIncorrect));
        
        $localStorage.score = score;
        $localStorage.sessionData = null;
        sessionPersister.delete();
        
        $location.path('/session-result');
    };
    
    $scope.timerFinished = function () {
        $scope.finish();
    };
    
    $scope.init(quizCreator.createQuiz(sessionData));
    $scope.start();
    
    if (sessionPersister.hasSession()) {
        var currentSession = sessionPersister.load();
        
        $scope.quizz = currentSession.quizz;
        $scope.currentQuestion = $scope.quizz.questions[currentSession.position];
    }
}]);
