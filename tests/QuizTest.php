<?php

namespace App\Tests;

use App\Entity\Question;
use App\Entity\Quiz;
use PHPUnit\Framework\TestCase;

class QuizTest extends TestCase
{
    public function testCreate(): void
    {
        $quiz = new Quiz();

        $this->assertInstanceOf(Quiz::class, $quiz);
    }

    public function testAddQuestionsToQuiz(): void
    {
        $quiz = new Quiz();
        $question1 = $this->createMock(Question::class);
        $question2 = $this->createMock(Question::class);
        $question3 = $this->createMock(Question::class);

        $quiz->addQuestion($question1)->addQuestion($question2)->addQuestion($question3);

        $this->assertCount(3, $quiz->getQuestions());
    }
}
