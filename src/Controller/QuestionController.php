<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Question;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/question/ask', name: 'app_question')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $question = new Question();
        $formQuestion = $this->createForm(QuestionType::class, $question);
        $formQuestion->handleRequest($request);
        if($formQuestion->isSubmitted() and $formQuestion->isValid()){
            $question->setCreatedAt(new \DateTimeImmutable());
            $question->setQuestionUser($this->getUser());
            $question->setRating(0);
            $question->setNbrOfResponse(0);
            $em->persist($question);
            $em->flush();
            $this->addFlash('succes', 'Votre question a correctement été envoyé !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('question/index.html.twig', [
            'formQuestion' => $formQuestion->createView(),
        ]);
    }


    #[Route('/question/{id}', name: 'app_question_show')]
    public function show(EntityManagerInterface $em, Request $request, Question $question): Response
    {
        $comment = new Comment();
        $formComment = $this->createForm(QuestionType::class, $comment);
        $formComment->handleRequest($request);
        if($formComment->isSubmitted() and $formComment->isValid()){
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setCommentUser($this->getUser());
            $comment->setRating(0);
            
            $question->setNbrOfResponse($question->getNbrOfResponse() + 1);
            $em->persist($question);
            $em->flush();
            $this->addFlash('succes', 'Votre commentaire a correctement été envoyé !');
            return $this->redirect($request->getUri());
        }

        return $this->render('question/show.html.twig', [
            'formComment' => $formComment->createView(),
        ]);
    }

    #[Route('/question/rating/{id}/{score}', name: 'question_rating')]
    public function ratingQuestion(Request $request, Question $question, int $score, EntityManagerInterface $em)
    {
        $question->setRating($question->getRating() + $score);
        $em->flush();
        $referer = $request->server->get('HTTP_REFERER');
        return $referer ? $this->redirect($referer) : $this->redirectToRoute('home');
    }

    #[Route('/comment/rating/{id}/{score}', name: 'comment_rating')]
    public function ratingComment(Request $request, Comment $comment, int $score, EntityManagerInterface $em)
    {
        $comment->setRating($comment->getRating() + $score);
        $em->flush();
        $referer = $request->server->get('HTTP_REFERER');
        return $referer ? $this->redirect($referer) : $this->redirectToRoute('home');
    }

}
