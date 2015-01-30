zcpe.controller('QuizCtrl', ['$scope', '$location', '$localStorage', '$controller', 'evaluator', 'quizCreator', 'restApi', function ($scope, $location, $localStorage, $controller, evaluator, quizCreator, restApi) {
    var sessionData = $localStorage.sessionData;
    
    $controller('QuizzCtrl', {$scope: $scope});
    
    $scope.questionChange = function () {
        saveQuiz();
    };
    
    var parentFinish = $scope.finish;
    $scope.finish = function () {
        parentFinish();
        
        var score = evaluator.evaluate($scope.quizz);
        
        restApi.postResults(sessionData.id, score);
        restApi.postAnswers(sessionData.id, $scope.quizz.questions.filter(evaluator.isAnswerIncorrect));
        
        $localStorage.score = score;
        $localStorage.sessionData = null;
        $localStorage.hasStoredQuiz = false;
        $localStorage.quizz = null;
        $localStorage.quizPosition = null;
        
        $location.path('/session-result');
    };
    
    /**
     * Persist user answers in local storage
     */
    function saveQuiz() {
        $localStorage.hasStoredQuiz = true;
        $localStorage.quizz = $scope.quizz;
        $localStorage.quizPosition = $scope.questionIndex();
    }
    
    /**
     * Load user answers from local storage
     */
    function loadQuiz() {
        $scope.quizz = $localStorage.quizz;
        $scope.currentQuestion = $scope.quizz.questions[$localStorage.quizPosition];
        
        refreshRadioAnswers($scope.quizz);
    }
    
    /**
     * Fix bug, set same answer object for radios
     * 
     * @param {Object} quizz
     */
    function refreshRadioAnswers(quizz) {
        angular.forEach(quizz.questions, function (question) {
            if ('radio' === question.type) {
                if (question.selectedAnswer) {
                    var i = 0;
                    var count = question.answers.length;
                    for (i = 0; i < count; i++) {
                        if (question.answers[i].id === question.selectedAnswer.id) {
                            question.selectedAnswer = question.answers[i];
                        }
                    }
                }
            }
        });
    }
    
    $scope.loadQuiz = loadQuiz;
    
    $scope.timerFinished = function () {
        $scope.finish();
    };
    
    $scope.init(quizCreator.createQuiz(sessionData));
    $scope.start();
    
    if ($localStorage.hasStoredQuiz) {
        loadQuiz();
    }
}]);
