<?php


namespace App\Validator\Constraints;

use App\Entity\Answer;
use App\Entity\Question;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AnswerChannel extends Constraint
{

    /**
     * @var string
     */
    public $message = 'the channel value must be "' . Answer::CHANNEL_FAQ . '" or "' . Answer::CHANNEL_BOT . '"';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return \get_class($this) . 'Validator';
    }
}