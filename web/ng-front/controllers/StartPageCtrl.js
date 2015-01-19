zcpe.controller('StartPageCtrl', ['$scope', '$location', '$localStorage', 'restApi', 'popup', function ($scope, $location, $localStorage, restApi, popup) {
    $scope.introTemplate = config.basePath + 'partials/intro.fr.html';
    $scope.startDisabled = false;
    
    $scope.start = function () {
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
