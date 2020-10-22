<?php

declare(strict_types=1);

namespace App\Infrastructure\UserInterface\Api;

use App\Application\CommandHandler\ListQuestionHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ListQuestionsController extends AbstractController
{

    /** @var ListQuestionHandler */
    private $listQuestionHandler;

    /**
     * ListQuestionHandlerController constructor.
     * @param SerializerInterface $serializerInterface
     * @param ListQuestionHandler $listQuestionHandler
     */
    public function __construct(ListQuestionHandler $listQuestionHandler)
    {
        $this->listQuestionHandler = $listQuestionHandler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $questions = $this->listQuestionHandler->handle();
        return $this->json($questions);
    }

}