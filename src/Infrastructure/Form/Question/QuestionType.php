<?php

namespace App\Infrastructure\Form\Question;

use App\Application\Command\CreateQuestionCommand;
use App\Application\Command\QuestionCommand;
use App\Entity\Question;
use App\Validator\Constraints\QuestionStatus;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Throwable;

/**
 * Class QuestionType
 * @package App\Infrastructure\Form\Question
 */
class QuestionType extends AbstractType implements DataMapperInterface
{
    use QuestionTypeTrait;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder = $this
            ->getBuildForm($builder)
            ->add('answers', CollectionType::class, [
                'entry_type' => AnswerQuestionType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->setDataMapper($this);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'empty_data' => null,
        ]);
    }

    /**
     * @param QuestionCommand $viewData
     * @param array $forms
     */
    public function mapDataToForms($viewData, $forms)
    {
        $forms = iterator_to_array($forms);
        $forms['id']->setData($viewData ? $viewData->id : '');
        $forms['title']->setData($viewData ? $viewData->title : '');
        $forms['status']->setData($viewData ? $viewData->status : '');
        $forms['promoted']->setData($viewData ? $viewData->promoted : '');
        $forms['answers']->setData($viewData ? $viewData->answers : []);
    }

    public function mapFormsToData($forms, &$viewData)
    {
        try {
            $forms = iterator_to_array($forms);
            $uuid = null !== $forms['id']->getData() ? $forms['id']->getData() : uniqid();
            $answers = $forms['answers']->getData();
            if ($answers instanceof Collection) {
                $answers = $answers->getValues();
            }
            $viewData = new QuestionCommand(
                $uuid,
                $forms['title']->getData(),
                $forms['promoted']->getData(),
                $forms['status']->getData(),
                $answers
            );
        } catch (Throwable $exception) {
            // Nothing to see here... We just need to catch it so symfony continues and eventually starts validating the form.
        }
    }
}
