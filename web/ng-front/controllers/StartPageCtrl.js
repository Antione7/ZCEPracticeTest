zcpe.controller('StartPageCtrl', ['$scope', '$location', '$localStorage', 'restApi', function ($scope, $location, $localStorage, restApi) {
    $scope.introTemplate = config.basePath + 'partials/intro.fr.html';
    $scope.startDisabled = false;
    
    $scope.start = function () {
        $scope.startDisabled = true;
        
        restApi.createSession(function (data) {
            $localStorage.sessionData = data;
            $location.path('/quiz');
        });
    };
}]);
