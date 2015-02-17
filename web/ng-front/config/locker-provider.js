zcpe.config(['lockerProvider', function (lockerProvider) {
    lockerProvider
        .setDefaultDriver('session')
        .setDefaultNamespace('certiphp')
        .setSeparator('.')
        .setEventsEnabled(false)
    ;
}]);
