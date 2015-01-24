zcpe.controller('QuizCtrl', ['$scope', '$location', '$localStorage', '$controller', 'evaluator', 'quizCreator', 'restApi', function ($scope, $location, $localStorage, $controller, evaluator, quizCreator, restApi) {
    var sessionData = $localStorage.sessionData;
    
    $controller('QuizzCtrl', {$scope: $scope});
    
    $scope.finish = function () {
        $scope.currentQuestion = null;
        $scope.finished = true;
        
        var score = evaluator.evaluate($scope.quizz);
        
        restApi.postResults(sessionData.id, score);
        restApi.postAnswers(sessionData.id, $scope.quizz.questions.filter(evaluator.isAnswerIncorrect));
        
        $localStorage.score = score;
        $localStorage.sessionData = null;
        
        $location.path('/session-result');
    };
    
    $scope.timerFinished = function () {
        $scope.finish();
    };
    
    $scope.init(quizCreator.createQuiz(sessionData));
    $scope.start();
}]);
