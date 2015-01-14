zcpe.controller('SessionsCtrl', ['$scope', '$location', 'restApi', function ($scope, $location, restApi) {
    $scope.goToStartPage = function () {
        $location.path('/new');
    };
    
    $scope.goToSession = function (sessionId)
    {
        $location.path('/session/' + sessionId);
    };
    
    restApi.getSessions(function (data) {
        $scope.sessions = data.sessions;
    });
}]);
