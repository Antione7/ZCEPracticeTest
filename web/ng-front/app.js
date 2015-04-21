var jsVars = {
    appBaseUrl:  null,
    appBasePath: null,
    
    init: function ()
    {
        var jsVarsAttributes = angular.element('#js-vars')[0].attributes;
        
        jsVars.appBaseUrl   = jsVarsAttributes['data-base-url'].value;
        jsVars.appBasePath  = jsVarsAttributes['data-basepath'].value;
    }
};

jsVars.init();

var config = {
    basePath: jsVars.appBasePath+'/ng-front/',
    restServer: jsVars.appBaseUrl+'/api'
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

/**
 * Filter to create a Javascript date
 */
angular.module('zcpeFilters', []).filter('jsDate', function () {
    return function (sDate) {
        return new Date(sDate);
    }
});

var zcpe = angular.module('zcpe', [
    'ngRoute',
    'pascalprecht.translate',
    'ngCookies',
    'ngStorage',
    'angular-locker',
    'controllers-quizz',
    'hljs',
    'timer',
    'zcpeFilters'
]);
