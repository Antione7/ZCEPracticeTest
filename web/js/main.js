
var Question =
{
    TYPE_QCM: 1,
    TYPE_FREE: 2
};

var ZCEApi =
{
    baseUrl: $('#js-vars').data('base-url'),
    
    createSession: function (callback)
    {
        $.ajax({
            type: 'POST',
            url: ZCEApi.baseUrl+'/api/session'
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
            url: ZCEApi.baseUrl+'/api/questions',
            data: data
        }).done(function (r) {
            callback && callback(r);
        });
    }
};

angular.module('quizz', ['controllers-quizz']);
angular.module('zcpe-quiz', ['quizz', 'btford.markdown']);
var $session = $('[data-session]');
angular.module('zcpe-quiz').constant('quizz', createQuiz($session.data('session')));

function createQuiz(data) {
    var questions = [];
    
    $.each(data.quiz.quizQuestions, function (i, questionData) {
        var question = questionData.question;
        var answers = [];
        
        if (question.type === Question.TYPE_QCM) {
            $.each(question.questionQCMChoices, function (j, questionQCMChoice) {
                answers.push({
                    text: questionQCMChoice.entitled,
                    correct: questionQCMChoice.isValid
                });
            });
        }
        
        if (question.type === Question.TYPE_FREE) {
            answers.push(question.freeAnswer);
        }
        
        questions.push({
            text: question.entitled,
            type: guessQuizQuestionType(question),
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

/**
 * Guess quiz type (radio, checkbox or free) of question
 * from ZCE:Question object data
 * 
 * @param {Object} question
 * 
 * @returns {string}
 */
function guessQuizQuestionType(question) {
    if (question.type === Question.TYPE_QCM) {
        if (question.nbAnswers > 1) {
            return 'checkbox';
        } else {
            return 'radio';
        }
    }
    
    if (question.type === Question.TYPE_FREE) {
        return 'free';
    }
    
    console && console.warn('Could not guess question type from data', question);
    return '';
}
