<?php

namespace App\Form;

use App\Validator\Constraints\QuestionStatus;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Trait QuestionTypeTrait
 * @package App\Form
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
            ->add('title')
            ->add('promoted')
            ->add('status', TextType::class, ['constraints' => new QuestionStatus()])
            ;
    }
}