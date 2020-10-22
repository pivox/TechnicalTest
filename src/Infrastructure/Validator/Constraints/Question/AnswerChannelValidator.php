<?php

namespace App\Infrastructure\Validator\Constraints\Question;

use App\Domain\Question\Model\Answer;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class AnswerChannelValidator
 * @package App\Validator\Constraints
 */
class AnswerChannelValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof AnswerChannel) {
            throw new UnexpectedTypeException($constraint, AnswerChannel::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if(!in_array($value, [Answer::CHANNEL_FAQ, Answer::CHANNEL_BOT])) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}