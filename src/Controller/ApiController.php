<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\Api\ApiQuestionType;
use App\Form\QuestionType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/question")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/put", name="question_put", methods={"PUT"})
     * @param Request $request
     * @param LoggerInterface $logger
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function put(Request $request, LoggerInterface $logger, ValidatorInterface $validator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);
        $logger->info($request->getContent());
        /** @var Question $question*/
        $question = $em
            ->getRepository('App:Question')
            ->find($data['id']);
        if(!$question) {
            return $this->json([], 404);
        }
        $form = $this->createForm(ApiQuestionType::class, $question);
        try{
            $form->submit($data);
            $validator->validate($question);
            if ($form->isValid()) {
                $em->flush();
                $em->clear();
                return $this->json([], 200);
            }
            else {
                $logger->critical(json_encode($form->getExtraData()));
                $logger->error($form->getErrors(true, false));
                return $this->json(['errors' => $this->getErrorsFromForm($form)], 400);
            }
        } catch (\Exception $e) {
            return $this->json(['errors' => $e->getMessage()], 400);
        }
    }


    private function getErrorsFromForm(FormInterface $form)
    {
        $formErrorIterator = $form->getErrors(true, false)->getChildren();
        $errors = [];
        /**@var FormError $formError*/
        foreach ($formErrorIterator as $formError) {
            if($formError->getOrigin()) {
                $errors[$formError->getOrigin()->getName()] = $formError->getMessage();
            } else {
                $errors[] = $formError->getMessage();
            }
        }
        return $errors;
    }
}