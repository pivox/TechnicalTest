<?php

namespace App\Infrastructure\Form\Question;

use App\Infrastructure\Validator\Constraints\Question\QuestionStatus;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Trait QuestionTypeTrait
 * @package App\Infrastructure\Form\Question
 */
trait QuestionTypeTrait
{
    /**
     * @param FormBuilderInterface $builder
     * @return FormBuilderInterface
     */
    public function getBuildForm(FormBuilderInterface $builder)
    {
        return $builder
            ->add('id', HiddenType::class)
            ->add('title', TextType::class)
            ->add('promoted', ChoiceType::class, [
                'choices' => [
                    'true' => true,
                    'false' => false,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('status', TextType::class, ['constraints' => new QuestionStatus()])
            ;
    }
}