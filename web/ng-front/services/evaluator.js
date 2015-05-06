zcpe.service('evaluator', function () {
    var self = this;
    
    /**
     * @param {Object} answered quiz
     * 
     * @returns {Object}
     */
    this.evaluate = function (quiz)
    {
        var goodAnswers = 0;
        var nbTopics = 0;
        var nbTopicsValidated = 0;
        var goodAnswersTopics = {};
        var nbQuestions = quiz.questions.length;
        var i;
        
        for (i = 0; i < nbQuestions; i++) {
            var question = quiz.questions[i];
            var topic = question.topic;
            
            if (!(topic.id in goodAnswersTopics)) {
                goodAnswersTopics[topic.id] = {
                    topic: topic,
                    good: 0,
                    total: 0,
                    validated: false
                };
            }
            
            goodAnswersTopics[topic.id].total++;
            
            if (self.isAnswerCorrect(question)) {
                goodAnswers++;
                goodAnswersTopics[topic.id].good++;
            }
        }
        
        angular.forEach(goodAnswersTopics, function (goodAnswersTopic) {
            nbTopics++;
            
            if ((goodAnswersTopic.good / goodAnswersTopic.total) >= 0.7) {
                goodAnswersTopic.validated = true;
                nbTopicsValidated++;
            }
        });
        
        return {
            nbTopics: nbTopics,
            nbTopicsValidated: nbTopicsValidated,
            success: (goodAnswers / nbQuestions) >= 0.7,
            topics: goodAnswersTopics
        };
    };
    
    /**
     * Return whether question answer is valid
     * 
     * @param {Object} question
     * @returns {Boolean}
     */
    this.isAnswerCorrect = function (question)
    {
        if (question.type === 'radio') {
            return question.selectedAnswer && question.selectedAnswer.correct;
        }
        else if (question.type === 'checkbox') {
            return question.answers.every(function(answer) {
                return ((answer.correct && answer.checked) || (!answer.correct && !answer.checked));
            });
        }
        else if (question.type === 'free') {
            return question.typedAnswer && question.answers.indexOf(question.typedAnswer.trim()) >= 0;
        }
        else {
            return false;
        }
    };
    
    /**
     * Return whether question answer is incorrect
     * 
     * @param {Object} question
     * @returns {Boolean}
     */
    this.isAnswerIncorrect = function (question)
    {
        return !self.isAnswerCorrect(question);
    };
});
