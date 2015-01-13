var config = {
    basePath: '../ng-front/',
    restServer: '../index.php/api'
};

var zcpe = angular.module('zcpe', [
    'ngRoute',
    'pascalprecht.translate',
    'ngStorage',
    'controllers-quizz',
    'btford.markdown',
    'hljs',
    'timer'
]);
