<?php

declare(strict_types=1);

namespace App\Infrastructure\UserInterface\Api;


use App\Application\CommandHandler\UpdateQuestionHandler;
use App\Application\Query\DetailQuestion;
use App\Infrastructure\Form\Question\Api\ApiQuestionType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateQuestionController extends AbstractController
{

    /** @var UpdateQuestionHandler*/
    private $updateQuestionHandler;

    /** @var DetailQuestion */
    private $detailQuestion;

    /** @var LoggerInterface */
    private $logger;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * UpdateQuestionController constructor.
     * @param UpdateQuestionHandler $updateQuestionHandler
     * @param DetailQuestion $detailQuestion
     */
    public function __construct(
        UpdateQuestionHandler $updateQuestionHandler,
        DetailQuestion $detailQuestion,
        LoggerInterface $logger,
        SerializerInterface $serializer,
        ValidatorInterface $validator
)
    {
        $this->updateQuestionHandler = $updateQuestionHandler;
        $this->detailQuestion = $detailQuestion;
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }


    public function __invoke(Request $request, string $id): Response
    {
        $questionCommandData = json_decode($request->getContent(),true);
        $questionCommand = $this->detailQuestion->setId($id)->execute()->getQuestionCommand();
        $form = $this->createForm(ApiQuestionType::class, $questionCommand);
        try {
            $form->submit($questionCommandData);
            $this->validator->validate($form->getData());
            if ($form->isValid()) {
                $questionCommand = $this->updateQuestionHandler->handle($form->getData());

                return $this->json($questionCommand);
            } else {
                return $this->json(['errors' => $this->serializer->serialize($this->getErrorsFromForm($form), 'json')], 400);
            }

        } catch (\Exception $ex) {
            $this->logger->error($ex->getMessage());
            $this->logger->error($ex->getTraceAsString());
            return $this->json(['errors' => $ex->getMessage()], 400);
        }
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    private function getErrorsFromForm(FormInterface $form): ?array
    {
        return array_map(function ($error){
            return $error->__toString();
        }, iterator_to_array($form->getErrors(true, false)));
    }
}