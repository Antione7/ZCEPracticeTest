zcpe.service('quizCreator', function () {
    /**
     * Create quiz object for ninja squad quiz
     * from data returned by rest server
     * 
     * @param {Object} data
     * @returns {Object}
     */
    this.createQuiz = function (data) {
        var questions = [];

        angular.forEach(data.quiz.quizQuestions, function (questionData) {
            var question = questionData.question;
            var answers = [];

            if (question.type === Question.TYPE_QCM) {
                angular.forEach(question.questionQCMChoices, function (questionQCMChoice) {
                    answers.push({
                        id: questionQCMChoice.id,
                        text: questionQCMChoice.entitled,
                        correct: questionQCMChoice.valid
                    });
                });
            }

            if (question.type === Question.TYPE_FREE) {
                answers = question.freeAnswer.split(',');
            }

            questions.push({
                id: question.id,
                text: question.entitled,
                type: guessQuizQuestionType(question),
                code: question.code,
                codeType: 'php',
                topic: question.topic,
                nbAnswers: question.nbAnswers,
                answers: answers
            });
        });

        var dateStart = new Date(data.dateStart.date.replace(/-/g, '/'));
        

        var quiz = {
            title: 'Title',
            description: 'Description',
            dateStart: dateStart.getTime() - dateStart.getTimezoneOffset() * 60000,
            time: 5400, // 90 minutes
            questions: questions
        };

        return quiz;
    };

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
    };
});
