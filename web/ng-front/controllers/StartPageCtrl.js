zcpe.controller('StartPageCtrl', ['$scope', '$location', '$localStorage', 'restApi', 'popup', 'sessionPersister', function ($scope, $location, $localStorage, restApi, popup, sessionPersister) {
    $scope.introTemplate = config.basePath + 'partials/intro.html';
    $scope.startDisabled = false;
    
    $scope.hasCurrentSession = sessionPersister.hasSession();
    
    $scope.goToCurrentSession = function ()
    {
        $location.path('/quiz');
    };
    
    $scope.start = function () {
        sessionPersister.delete();
        $scope.startDisabled = true;
        
        restApi.createSession(function (data) {
            if (data.ok) {
                $localStorage.sessionData = data.session;
                $location.path('/quiz');
            } else {
                $scope.startDisabled = false;
                popup.display(data.reason);
            }
        });
    };
}]);
