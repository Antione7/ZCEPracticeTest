$(function () {
    bindStartButton();
});

var ZCEApi =
{
    basepath: $('#js-vars').data('basepath')+'/index.php/',
    
    createSession: function (callback)
    {
        $.ajax({
            type: 'POST',
            url: ZCEApi.basepath+'api/session'
        }).done(function (r) {
            callback && callback(r);
        });
    },
    
    getQuiz: function (quizId, callback)
    {
        var data = {
            quizId: quizId
        };
        
        $.ajax({
            type: 'GET',
            url: ZCEApi.basepath+'api/questions',
            data: data
        }).done(function (r) {
            callback && callback(r);
        });
    }
};

function bindStartButton() {
    if ($('#create-session').size()) {
        $('#create-session').click(function () {
            createAndRunSession();
        });
    }
}

function createAndRunSession() {
    ZCEApi.createSession(function (data) {
        console.log('data', data);
        var quiz = createQuiz(data);
    });
}

function createQuiz(data) {
    var questions = [];
    
    $.each(data.quiz.quizQuestions, function (i, questionData) {
        var question = questionData.question;
        var answers = [];
        
        $.each(question.questionQCMChoices, function (j, questionQCMChoice) {
            answers.push({
                text: questionQCMChoice.entitled,
                correct: questionQCMChoice.isValid
            });
        });
        
        questions.push({
            text: question.entitled,
            type: (question.nbAnswers > 1) ? 'checkbox' : 'radio',
            answers: answers
        });
    });
    
    var quiz = {
        title: 'Title',
        description: 'Description',
        questions: questions
    };
    
    return quiz;
}
