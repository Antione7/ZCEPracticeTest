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
            data.sessions[i].dateFinished.date = data.sessions[i].dateStart.date.replace(/-/g, '/').replace('.000000','');
        }
        $scope.sessions = data.sessions;
    });
}]);
