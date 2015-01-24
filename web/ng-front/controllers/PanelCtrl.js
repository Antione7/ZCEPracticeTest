zcpe.controller('PanelCtrl', ['$scope', '$location', 'restApi', function ($scope, $location, restApi) {
    $scope.goToStartPage = function () {
        $location.path('/session-new');
    };
    
    $scope.goToSession = function (sessionId)
    {
        $location.path('/session/' + sessionId);
    };
    
    restApi.getSessions(function (data) {
        $scope.sessions = data.sessions;
    });
}]);
