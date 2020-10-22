<?php

namespace App\Infrastructure\UserInterface\Html;

use App\Application\CommandHandler\CreateQuestionHandler;
use App\Application\Query\DetailQuestion;
use App\Application\Query\ListQuestions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class DetailQuestionController extends AbstractController
{
    /** @var DetailQuestion */
    private $query;

    /** @var Environment */
    private $templating;

    /**
     * CreateQuestionController constructor.
     * @param CreateQuestionHandler $handler
     */
    public function __construct(Environment $templating, DetailQuestion $query)
    {
        $this->query = $query;
        $this->templating = $templating;
    }

    public function __invoke(string $id): Response
    {
        return new Response($this->templating->render('question/detail.html.twig', [
            'question' => $this->query->setId($id)->execute()->getQuestionCommand(),
        ]));
    }
}
