<?php

namespace App\Controller;

use App\Entity\QuestionOption;
use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * QuizController constructor.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/quiz/{id}", name="get_quiz", methods={"GET"})
     */
    public function getQuiz(int $id): Response
    {
        $quiz = $this->em->find(Quiz::class, $id);
        if (is_null($quiz)) {
            return $this->json(['error' => 'Quiz not found.'], JsonResponse::HTTP_NOT_FOUND);
        }


        return $this->json($quiz, JsonResponse::HTTP_OK, [], ['groups' => 'get']);
    }

    /**
     * @Route("/quiz/{id}", name="submit_quiz", methods={"POST"})
     */
    public function submitQuiz(int $id, Request $request): Response
    {
        $request = $this->transformJsonBodyRequest($request);
        $quiz = $this->em->find(Quiz::class, $id);
        if (is_null($quiz)) {
            return $this->json(['error' => 'Quiz not found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $score = $this->scoreQuiz($request->request->get('responses'));
        return $this->json(["score" => $score]);
    }

    private function scoreQuiz($responses): int
    {
        $score = 0;
        foreach ($responses as $response) {
            $option = $this->em->find(QuestionOption::class, $response['option']);
            if ($option && $option->isAnswer()) {
                $score++;
            }
        }
        return $score;
    }

    private function transformJsonBodyRequest(Request $request): Request
    {
        $data = json_decode($request->getContent(), true);

        if (is_null($data)) {
            return $request;
        }

        $request->request->replace($data);
        return $request;
    }
}
