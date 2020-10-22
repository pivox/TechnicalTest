<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\AnswerCommand;
use App\Application\Command\QuestionCommand;
use App\Application\Query\DetailAnswer;
use App\Application\Query\DetailQuestion;
use App\Domain\Question\Model\Answer;
use App\Domain\Question\Model\Question;
use App\Domain\Question\Port\QuestionRepository;

class UpdateQuestionHandler
{

    /** @var QuestionRepository */
    private $questionRepository;

    /** @var DetailAnswer */
    private $detailAnswer;

    /** @var DetailQuestion */
    private $detailQuestion;

    /** @var DetailQuestion */
//    private $detailQuestion;

//    /** @var DetailAnswer */
//    private $detailAnswer;

    /**
     * CreateQuestionHandler constructor.
     * @param QuestionRepository $questionRepository
     */
    public function __construct(DetailQuestion $detailQuestion,QuestionRepository $questionRepository, DetailAnswer $detailAnswer)
    {
        $this->detailQuestion = $detailQuestion;
        $this->questionRepository = $questionRepository;
        $this->detailAnswer = $detailAnswer;
    }

    public function handle(QuestionCommand $questionCommand): QuestionCommand
    {
        $question = $this
            ->detailQuestion
            ->setId($questionCommand->id)
            ->execute()
            ->getQuestion();
        $answers = $this->getAnswersQuestion($question, $questionCommand);
        $question->update(
            $questionCommand->title,
            $questionCommand->promoted,
            $questionCommand->status,
            $answers
        );
        $this->questionRepository->save($question);

        return $questionCommand;
    }

    private function getAnswersQuestion(Question $question, QuestionCommand $questionCommand): ?iterable
    {
        $questionAnswers = $question->getAnswers();
        foreach ($questionAnswers as $key => $answer) {
            unset($questionAnswers[$key]);
        }
        /** @var AnswerCommand $answer*/
        foreach ($questionCommand->answers as $answer) {
            $answerObject = $this
                ->detailAnswer
                ->setId($answer->id)
                ->execute()
                ->getAnswer();
            if (null === $answerObject) {
                $answerObject = new Answer($answer->channel, $answer->body);
            } else {
                /** @var Answer $answerObject*/
                $answerObject->update($answer->channel, $answer->body);
            }
            $answerObject->setQuestion($question);
            $questionAnswers[count($questionAnswers)] = $answerObject;
        }
        return $questionAnswers;
    }

}