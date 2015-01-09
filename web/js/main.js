
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
        var goodAnswers = 0;
        var nbTopics = 0;
        var nbTopicsValidated = 0;
        var goodAnswersTopics = {};
        var nbQuestions = quiz.questions.length;
        var i;
        
        for (i = 0; i < nbQuestions; i++) {
            var question = quiz.questions[i];
            var topic = question.topic;
            
            if (!(topic.id in goodAnswersTopics)) {
                goodAnswersTopics[topic.id] = {
                    topic: topic,
                    good: 0,
                    total: 0,
                    validated: false
                };
            }
            
            goodAnswersTopics[topic.id].total++;
            
            if (Evaluator.isAnswerCorrect(question)) {
                goodAnswers++;
                goodAnswersTopics[topic.id].good++;
            }
        }
        
        angular.forEach(goodAnswersTopics, function (goodAnswersTopic) {
            nbTopics++;
            
            if ((goodAnswersTopic.good / goodAnswersTopic.total) >= 0.7) {
                goodAnswersTopic.validated = true;
                nbTopicsValidated++;
            }
        });
        
        return {
            nbTopics: nbTopics,
            nbTopicsValidated: nbTopicsValidated,
            success: (goodAnswers / nbQuestions) >= 0.7,
            topics: goodAnswersTopics
        };
    },
    
    isAnswerCorrect: function (question)
    {
        if (question.type === 'radio') {
            return question.selectedAnswer && question.selectedAnswer.correct;
        }
        else if (question.type === 'checkbox') {
            return question.answers.every(function(answer) {
                return ((answer.correct && answer.checked) || (!answer.correct && !answer.checked));
            });
        }
        else if (question.type === 'free') {
            return question.typedAnswer && question.answers.indexOf(question.typedAnswer.trim()) >= 0;
        }
        else {
            return false;
        }
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
            topic: question.topic,
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
