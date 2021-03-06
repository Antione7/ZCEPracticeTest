zcpe.controller('PanelCtrl', ['$scope', '$location', 'restApi', 'sessionPersister', function ($scope, $location, restApi, sessionPersister) {
    $scope.goToStartPage = function () {
        $location.path('/session-new');
    };
    
    $scope.goToSession = function (sessionId)
    {
        $location.path('/session/' + sessionId);
    };
    
    $scope.hasCurrentSession = sessionPersister.hasSession();
    
    if ($scope.hasCurrentSession) {
        var sessionData = sessionPersister.load();
        
        $scope.quizz = sessionData.quizz;
        $scope.position = sessionData.position;
    }
    
    $scope.goToCurrentSession = function ()
    {
        $location.path('/quiz');
    };
    
    $scope.timerFinished = function ()
    {
        $scope.hasCurrentSession = false;
        sessionPersister.delete();
    };
    
    restApi.getSessions(function (data) {
        for(i=0; i < data.sessions.length; i++){
            if(data.sessions[i].dateFinished !== null){
               data.sessions[i].dateFinished.date = data.sessions[i].dateFinished.date.replace(/ /g, 'T').replace('.000000','Z');
            }
            if(data.sessions[i].dateStart !== null){
               data.sessions[i].dateStart.date = data.sessions[i].dateStart.date.replace(/ /g, 'T').replace('.000000','Z');
            }
        }
        $scope.sessions = data.sessions;
    });
}]);
