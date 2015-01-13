zcpe.controller('ResultCtrl', ['$scope', '$location', '$http', '$localStorage', '$controller', function ($scope, $location, $http, $localStorage, $controller) {
    var quizz = $localStorage.quizz;
    
    $controller('QuizzCtrl', {$scope: $scope});
    
    $scope.init(quizz);
    $scope.finish();
    $scope.score = $localStorage.score;
}]);
