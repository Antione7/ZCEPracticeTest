zcpe.service('sessionPersister', ['$localStorage', function ($localStorage) {
    var _self = this;
    
    /**
     * Persist user answers in local storage
     * 
     * @param {Object} quizz data to save
     * @param {Integer} quiz position
     */
    this.save = function (quizz, position)
    {
        $localStorage.hasStoredQuiz = true;
        $localStorage.quizz = quizz;
        $localStorage.quizPosition = position;
    };
    
    /**
     * Returns whether there is a current session
     * 
     * @returns {Boolean}
     */
    this.hasSession = function ()
    {
        return $localStorage.hasStoredQuiz;
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
        
        var quizz = $localStorage.quizz;
        
        refreshRadioAnswers(quizz);
        
        return {
            quizz: quizz,
            position: $localStorage.quizPosition
        };
    };
    
    /**
     * Delete current session
     */
    this.delete = function ()
    {
        $localStorage.hasStoredQuiz = false;
        $localStorage.quizz = null;
        $localStorage.quizPosition = null;
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
