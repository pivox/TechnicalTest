<?php

declare(strict_types=1);

namespace App\Infrastructure\UserInterface\Api;


use App\Application\CommandHandler\DetailQuestionHandler;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DetailQuestionController extends AbstractController
{
    /** @var DetailQuestionHandler */
    private $detailHandlerQuestion;

    /** @var LoggerInterface */
    private $logger;

    /**
     * DetailQuestionController constructor.
     * @param DetailQuestionHandler $detailHandlerQuestion
     */
    public function __construct(DetailQuestionHandler $detailHandlerQuestion, LoggerInterface $logger)
    {
        $this->detailHandlerQuestion = $detailHandlerQuestion;
        $this->logger = $logger;
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $this->logger->critical('$request');
        $questionCommand = $this->detailHandlerQuestion->handle($id);
        return $this->json($questionCommand);
    }
}