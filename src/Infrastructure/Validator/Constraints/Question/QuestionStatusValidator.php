<?php

namespace App\Infrastructure\Validator\Constraints\Question;

use App\Domain\Question\Model\Question;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class QuestionStatusValidator
 * @package App\Validator\Constraints
 */
class QuestionStatusValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof QuestionStatus) {
            throw new UnexpectedTypeException($constraint, QuestionStatus::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if(!in_array($value, [Question::STATUS_PUBLISHED, Question::STATUS_DRAFT])) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}