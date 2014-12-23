$(function () {
    initSessionPage();
    bindStartButton();
});

var ZCEApi =
{
    baseUrl: $('#js-vars').data('base-url')+'/',
    
    createSession: function (callback)
    {
        $.ajax({
            type: 'POST',
            url: ZCEApi.baseUrl+'api/session'
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
            url: ZCEApi.baseUrl+'api/questions',
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

function initSessionPage() {
    if ($('#quiz-page').size()) {
        console.log('init page');
        angular.module('quizz', ['controllers-quizz']);
        angular.module('zcpe-quiz', ['quizz', 'btford.markdown', 'ngAnimate']);
    }
}

function createAndRunSession() {
    ZCEApi.createSession(function (data) {
        var quiz = createQuiz(data);
        
        angular.module('zcpe-quiz').constant('quizz', quiz);
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
