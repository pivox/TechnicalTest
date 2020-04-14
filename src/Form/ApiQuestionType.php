<?php

namespace App\Form\Api;

use App\Entity\Question;
use App\Form\AnswerQuestionType;
use App\Form\ApiAnswerType;
use App\Form\QuestionTypeTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApiQuestionType extends AbstractType
{
    use QuestionTypeTrait;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder = $this->getBuildForm($builder);
        $builder
            ->add('id')
            ->add('updated', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd H:mm:s',
            ])
            ->add('answers', CollectionType::class, [
                'entry_type' => ApiAnswerType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'csrf_protection' => false,
        ]);
    }
}