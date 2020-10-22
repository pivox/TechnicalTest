<?php

declare(strict_types=1);

namespace App\Infrastructure\UserInterface\Html;

use App\Application\CommandHandler\CreateQuestionHandler;
use App\Application\Query\ListQuestions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ListQuestionsController extends AbstractController
{
    /** @var ListQuestions */
    private $query;

    /** @var Environment */
    private $templating;

    /**
     * CreateQuestionController constructor.
     * @param CreateQuestionHandler $handler
     */
    public function __construct(Environment $templating, ListQuestions $query)
    {
        $this->query = $query;
        $this->templating = $templating;
    }

    public function __invoke(Request $request): Response
    {
        return new Response($this->templating->render('question/index.html.twig', [
            'questions' => $this->query->execute(),
        ]));
    }
}
