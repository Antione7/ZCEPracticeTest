zcpe.controller('ResultCtrl', ['$scope', '$localStorage', '$controller', function ($scope, $localStorage, $controller) {
    var quizz = $localStorage.quizz;
    
    $controller('QuizzCtrl', {$scope: $scope});
    
    $scope.init(quizz);
    $scope.finish();
    $scope.score = $localStorage.score;
}]);
