zcpe.service('restApi', ['$http', function ($http) {
    /**
     * Create a zcpe session
     * 
     * @param {Function} callback
     */
    this.createSession = function (callback)
    {
        $http.post(config.restServer + '/session').success(callback);
    };
    
    /**
     * Post session score
     * 
     * @param {integer} sessionId
     * @param {Object} score
     */
    this.postResults = function (sessionId, score)
    {
        $http({
            url: config.restServer + '/session/finish/' + sessionId,
            method: 'POST',
            data: score
        });
    };
    
    /**
     * Post multiple answers
     * 
     * @param {integer} sessionId
     * @param {Array} answersData
     */
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
        
        $http({
            url: config.restServer + '/session/' + sessionId + '/answers',
            method: 'POST',
            data: answers
        });
    };
    
    /**
     * Get all sessions fur current user
     * 
     * @param {Function} callback
     */
    this.getSessions = function (callback)
    {
        $http.get(config.restServer + '/sessions').success(callback);
    };
    
    /**
     * Get session data with answers
     * 
     * @param {integer} sessionId
     * @param {Function} callback
     * 
     * @returns {Object}
     */
    this.getSession = function (sessionId, callback)
    {
        $http({
            url: config.restServer + '/session/' + sessionId,
            method: 'GET'
        }).success(callback);
    };
}]);
