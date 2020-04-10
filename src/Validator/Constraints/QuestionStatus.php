<?php

namespace App\Validator\Constraints;

use App\Entity\Question;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class QuestionStatus extends Constraint
{
    /**
     * @var string
     */
    public $message = 'the status value must be "'.Question::STATUS_DRAFT.'" or '.Question::STATUS_PUBLISHED.'"';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}