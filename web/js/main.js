$(function () {
    
});

var ZCEApi =
{
    basepath: $('#js-vars').data('basepath')+'/index.php/',
    
    createSession: function ()
    {
        $.ajax({
            type: 'POST',
            url: ZCEApi.basepath+'api/session'
        }).done(function (r) {
            console.log(r);
        });
    },
    
    getQuiz: function (quizId)
    {
        var data = {
            quizId: quizId
        };
        
        $.ajax({
            type: 'GET',
            url: ZCEApi.basepath+'api/questions',
            data: data
        }).done(function (r) {
            console.log(r);
        });
    }
};
