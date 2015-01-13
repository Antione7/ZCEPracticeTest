/**
 * Override timer directive to add an extra parameter
 */
zcpe.config(function($provide) {
    $provide.decorator('timerDirective', function($delegate) {
        var directive = $delegate[0];
        angular.extend(directive.scope, {
            quizMaxTime:'='
        });
        return $delegate;
    });
});
