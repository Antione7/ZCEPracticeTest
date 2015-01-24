var config = {
    basePath: '../ng-front/',
    restServer: '../index.php/api'
};

var Question =
{
    TYPE_QCM: 1,
    TYPE_FREE: 2
};

var zcpe = angular.module('zcpe', [
    'ngRoute',
    'pascalprecht.translate',
    'ngCookies',
    'ngStorage',
    'controllers-quizz',
    'hljs',
    'timer'
]);
