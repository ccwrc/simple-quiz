<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Answer;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    public function testCreate(): void
    {
        $answer = new Answer();

        $this->assertInstanceOf(Answer::class, $answer);
        $this->assertFalse($answer->getIsCorrect());
    }
}
