zcpe.controller('QuizCtrl', ['$scope', '$location', '$localStorage', '$controller', 'evaluator', 'quizCreator', 'restApi', 'sessionPersister', function ($scope, $location, $localStorage, $controller, evaluator, quizCreator, restApi, sessionPersister) {
    var sessionData = $localStorage.sessionData;
    
    $controller('QuizzCtrl', {$scope: $scope});
    
    $scope.questionChange = function () {
        sessionPersister.save($scope.quizz, $scope.questionIndex());
    };
    
    var parentFinish = $scope.finish;
    $scope.finish = function () {
        if (!confirm('Terminate session and go to result screen ?')) {
            return;
        }
        
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
    
    function isChecked(answer) {
        return answer.checked;
    };
    
    $scope.nbChecked = function (question) {
        return question.answers.filter(isChecked).length;
    };
    
    $scope.hasCheckedMaxChoices = function (question) {
        return $scope.nbChecked(question) >= question.nbAnswers;
    };
    
    if (sessionPersister.hasSession()) {
        var currentSession = sessionPersister.load();
        
        $scope.quizz = currentSession.quizz;
        $scope.currentQuestion = $scope.quizz.questions[currentSession.position];
    } else {
        sessionPersister.save($scope.quizz, $scope.questionIndex());
    }
}]);
