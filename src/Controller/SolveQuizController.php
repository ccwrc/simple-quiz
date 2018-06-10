<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Form\SolveQuizType;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SolveQuizController extends Controller
{
    /**
     * @Route("/solve/quiz", name="solve_quiz")
     */
    public function index(QuizRepository $quizRepository): Response
    {
        return $this->render('solve_quiz/index.html.twig', [
            'quizzes' => $quizRepository->findAll()
        ]);
    }

    /**
     * A real Godzilla function.
     *
     * @Route("/solve/{id}/quiz", name="solve_quiz_by_id")
     */
    public function solveQuizById(Request $request, Quiz $quiz): Response
    {
        $beforeAnswers = [];
        $afterAnswers = [];

        foreach ($quiz->getQuestions() as $question) {
            foreach ($question->getAnswers() as $answer) {
                $beforeAnswers[] = $answer->getIsCorrect();
            }
        }

        $answersCounter = \count($beforeAnswers);
        $correctAnswersCounter = 0;

        foreach ($quiz->getQuestions() as $question) {
            foreach ($question->getAnswers() as $answer) {
                $answer->setIsCorrect(false);
            }
        }

        $form = $this->createForm(SolveQuizType::class, $quiz);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->getData()->getQuestions() as $question) {
                foreach ($question->getAnswers() as $answer) {
                    $afterAnswers[] = $answer->getIsCorrect();
                }
            }

            for ($i = 0; $i < $answersCounter; $i++) {
                if ($beforeAnswers[$i] === $afterAnswers[$i]) {
                    $correctAnswersCounter++;
                }
            }

            try {
                $quizPercentageResult = (int)($correctAnswersCounter / $answersCounter * 100);
            } catch (\Exception $e) {
                $quizPercentageResult = 0;
            }

            if ($quizPercentageResult >= $quiz->getPercentageCorrectnessToWin()) {
                $quizResult = 'success';
            } else {
                $quizResult = 'fail';
            }

            return $this->render('solve_quiz/result.html.twig', [
                'quizResult' => $quizResult,
                'quizPercentageResult' => $quizPercentageResult,
                'quiz' => $quiz
            ]);
        }

        return $this->render('solve_quiz/solve.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
