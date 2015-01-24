zcpe.controller('SessionCtrl', ['$scope', '$routeParams', 'restApi', function ($scope, $routeParams, restApi) {
    var sessionId = $routeParams.sessionId;
    $scope.session = null;
    $scope.Question = Question;
    
    restApi.getSession(sessionId, function (data) {
        $scope.session = data.session;
        $scope.sessionDuration = calculDuration($scope.session.dateStart.date, $scope.session.dateFinished.date);
    });
    
    $scope.hasChecked = function (answer, choiceId)
    {
        var length = answer.answerQCMChoices.length;
        
        for (var i = 0; i < length; i++) {
            var answerQCMChoice = answer.answerQCMChoices[i];
            
            if (answerQCMChoice.questionQCMChoice.id === choiceId) {
                return true;
            }
        }
        
        return false;
    };
    
    /**
     * Return minutes between date0 and date1
     * 
     * @param {string} date0
     * @param {string} date1
     * 
     * @returns {integer}
     */
    function calculDuration(date0, date1) {
        var d0 = new Date(date0.replace(/-/g, '/')).getTime();
        var d1 = new Date(date1.replace(/-/g, '/')).getTime();
        
        var seconds = Math.abs(d1 - d0);
        
        return Math.round(seconds / 60000);
    }
}]);
