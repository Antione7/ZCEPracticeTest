zcpe.service('popup', ['$translate', function ($translate) {
    this.display = function (msg)
    {
        alert($translate.instant(msg));
    };
}]);
