zcpe.controller('SessionCtrl', ['$scope', '$routeParams', 'restApi', function ($scope, $routeParams, restApi) {
    var sessionId = $routeParams.sessionId;
    $scope.session = null;
    $scope.Question = Question;
    
    restApi.getSession(sessionId, function (data) {
        data.session.dateStart.date = data.session.dateStart.date.replace(/ /g, 'T').replace('.000000','Z');
        data.session.dateFinished.date = data.session.dateFinished.date.replace(/ /g, 'T').replace('.000000','Z');
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
        var seconds = Math.abs(new Date(date1).getTime() - new Date(date0).getTime());
        
        return Math.round(seconds / 60000);
    }
}]);
