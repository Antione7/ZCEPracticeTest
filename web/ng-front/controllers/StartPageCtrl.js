zcpe.controller('StartPageCtrl', ['$scope', '$location', '$http', '$localStorage', function ($scope, $location, $http, $localStorage) {
    $scope.introTemplate = config.basePath + 'partials/intro.fr.html';
    $scope.startDisabled = false;
    
    $scope.start = function () {
        $scope.startDisabled = true;
        
        $http.post(config.restServer+'/session').success(function (data) {
            $localStorage.sessionData = data;
            $location.path('/quiz');
        });
    };
}]);
