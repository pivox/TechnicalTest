<?php

namespace App\Infrastructure\UserInterface\Html;

use App\Application\Query\DetailQuestion;
use App\Infrastructure\Form\Question\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Application\CommandHandler\UpdateQuestionHandler;
use Twig\Environment;

class UpdateQuestionController extends AbstractController
{

    /** @var UpdateQuestionHandler*/
    private $updateQuestionHandler;

    /** @var DetailQuestion */
    private $detailQuestion;

    /** @var Environment */
    private $templating;

    /**
     * UpdateQuestionController constructor.
     * @param UpdateQuestionHandler $handler
     */
    public function __construct(Environment $templating, UpdateQuestionHandler $updateQuestionHandler, DetailQuestion $detailQuestion)
    {
        $this->updateQuestionHandler = $updateQuestionHandler;
        $this->detailQuestion = $detailQuestion;
        $this->templating = $templating;
    }

    public function __invoke(Request $request, string $id): Response
    {
        $questionCommand = $this
            ->detailQuestion
            ->setId($id)
            ->execute()
            ->getQuestionCommand();
        $form = $this->createForm(QuestionType::class, $questionCommand);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->updateQuestionHandler->handle($data);
            return $this->redirectToRoute('question_list');
        }

        return $this->render('question/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
//
//    public function show(Question $question): Response
//    {
//        return $this->render('question/show.html.twig', [
//            'question' => $question,
//        ]);
//    }
//
//    public function edit(Request $request, Question $question): Response
//    {
//        $form = $this->createForm(QuestionType::class, $question);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//            return $this->redirectToRoute('question_index');
//        }
//
//        return $this->render('question/edit.html.twig', [
//            'question' => $question,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    public function delete(Request $request, Question $question): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($question);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('question_index');
//    }
}
