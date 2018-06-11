<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Question;
use App\Entity\Quiz;
use PHPUnit\Framework\TestCase;

class QuizTest extends TestCase
{
    public function testCreate(): Quiz
    {
        $quiz = new Quiz();

        $this->assertInstanceOf(Quiz::class, $quiz);

        return $quiz;
    }

    /**
     * @depends testCreate
     */
    public function testAddQuestionsToQuiz(Quiz $quiz): void
    {
        $question1 = $this->createMock(Question::class);
        $question2 = $this->createMock(Question::class);
        $question3 = $this->createMock(Question::class);

        $quiz->addQuestion($question1)->addQuestion($question2)->addQuestion($question3);

        $this->assertCount(3, $quiz->getQuestions());
    }
}
