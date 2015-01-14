zcpe.controller('SessionsCtrl', ['$scope', '$location', '$http', function ($scope, $location, $http) {
    $scope.goToStartPage = function () {
        $location.path('/new');
    };
    
    $scope.goToSession = function (sessionId)
    {
        $location.path('/session/' + sessionId);
    }
    
    $http.get(config.restServer+'/sessions').success(function (data) {
        $scope.sessions = data.sessions;
    });
}]);
