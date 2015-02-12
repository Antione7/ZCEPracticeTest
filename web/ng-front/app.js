var config = {
    basePath: '../ng-front/',
    restServer: '../index.php/api'
};

var Question =
{
    TYPE_QCM: 1,
    TYPE_FREE: 2
};

function getUTCTimestamp() {
    var now = new Date();
    var utc_now = new Date(
        now.getUTCFullYear(),
        now.getUTCMonth(),
        now.getUTCDate(),
        now.getUTCHours(),
        now.getUTCMinutes(),
        now.getUTCSeconds(),
        now.getUTCMilliseconds()
    );
    return utc_now.getTime();
}

var zcpe = angular.module('zcpe', [
    'ngRoute',
    'pascalprecht.translate',
    'ngCookies',
    'ngStorage',
    'controllers-quizz',
    'hljs',
    'timer'
]);
