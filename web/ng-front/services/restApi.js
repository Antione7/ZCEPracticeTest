zcpe.service('restApi', ['$http', function ($http) {
    this.postAnswers = function (sessionId, answersData)
    {
        var answers = {};
        
        angular.forEach(answersData, function (answerData) {
            var answer = {
                tagged: false,
                questionId: answerData.id
            };
            
            if (answerData.type === 'radio') {
                answer.type = Question.TYPE_QCM;
                if (answerData.selectedAnswer) {
                    answer.selected = [answerData.selectedAnswer.id];
                } else {
                    answer.selected = [];
                }
            }
            else if (answerData.type === 'checkbox') {
                answer.type = Question.TYPE_QCM;
                answer.selected = [];
                
                angular.forEach(answerData.answers, function (choice) {
                    if (choice.checked) {
                        answer.selected.push(choice.id);
                    }
                })
            }
            else if (answerData.type === 'free') {
                answer.type = Question.TYPE_FREE;
                answer.freeAnswer = answerData.typedAnswer ? answerData.typedAnswer : '';
            }
            else {
                return false;
            }
            
            answers[answer.questionId] = answer;
        });
        
        console.log(answers);
        
        $http({
            url: config.restServer + '/session/' + sessionId + '/answers',
            method: 'POST',
            data: answers
        });
    };
}]);
