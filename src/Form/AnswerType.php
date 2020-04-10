<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('channel')
            ->add('body')
            ->add('question', EntityType::class, [
                'class' => Question::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('q')
                        ->orderBy('q.title', 'ASC');
                },
                'choice_label' => 'title',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
