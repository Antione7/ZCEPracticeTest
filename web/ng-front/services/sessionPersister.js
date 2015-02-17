zcpe.service('sessionPersister', ['locker', function (locker) {
    var _self = this;
    
    /**
     * Persist user answers in local storage
     * 
     * @param {Object} quizz data to save
     * @param {Integer} quiz position
     */
    this.save = function (quizz, position)
    {
        locker.put({
            hasStoredQuiz: true,
            quizz: quizz,
            quizPosition: position
        });
    };
    
    /**
     * Returns whether there is a current session
     * 
     * @returns {Boolean}
     */
    this.hasSession = function ()
    {
        return locker.get('hasStoredQuiz');
    };
    
    /**
     * Load user answers from local storage
     * 
     * @return {Object} containing current quizz data and position
     */
    this.load = function ()
    {
        if (!_self.hasSession()) {
            return null;
        }
        
        var quizz = locker.get('quizz');
        
        refreshRadioAnswers(quizz);
        
        return {
            quizz: quizz,
            position: locker.get('quizPosition')
        };
    };
    
    /**
     * Delete current session
     */
    this.delete = function ()
    {
        locker.put('hasStoredQuiz', false);
        
        locker.forget([
            'quizz',
            'quizPosition'
        ]);
    };
    
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
    };
    
    /**
     * Delete current session if over
     */
    deleteIfTimeOver();
    
    function deleteIfTimeOver() {
        if (_self.hasSession()) {
            var data = _self.load();
            if (getUTCTimestamp() >= (data.quizz.dateStart + data.quizz.time * 1000)) {
                _self.delete();
            }
        }
    }
}]);
