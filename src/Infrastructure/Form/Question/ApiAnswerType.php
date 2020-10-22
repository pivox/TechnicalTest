<?php

namespace App\Infrastructure\Form\Question;

use App\Application\Command\AnswerCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApiAnswerType extends AbstractType implements DataMapperInterface
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('channel')
            ->add('body')
            ->add('question')
            ->setDataMapper($this)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'empty_data' => null,
        ]);
    }


    /**
     * @param  AnswerCommand $viewData
     * @param  array $forms
     */
    public function mapDataToForms($viewData, $forms)
    {
        $forms = iterator_to_array($forms);
        if (is_array($viewData)) {
            $viewData = (object) $viewData;
        }
        $forms['id']->setData($viewData ? $viewData->id : '');
        $forms['channel']->setData($viewData ? $viewData->channel : '');
        $forms['body']->setData($viewData ? $viewData->body : '');
    }

    public function mapFormsToData($forms, &$viewData)
    {
        try {
            $forms = iterator_to_array($forms);
            $uuid = null !== $forms['id']->getData() ? $forms['id']->getData(): uniqid();
            $viewData = new AnswerCommand(
                $uuid,
                $forms['channel']->getData(),
                $forms['body']->getData()
            );
        } catch (Throwable $ex) {

        }
    }
}
