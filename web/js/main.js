
var Question =
{
    TYPE_QCM: 1,
    TYPE_FREE: 2
};

var Evaluator =
{
    /**
     * @param {Object} answered quiz
     * 
     * @returns {Object}
     */
    evaluate: function (quiz)
    {
        console.log(quiz);
        
        return {
            nbTopicsValidated: 2,
            success: false
        };
    }
};

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
            code: question.code,
            codeType: 'php',
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
