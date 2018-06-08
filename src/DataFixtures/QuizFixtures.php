<?php

namespace App\DataFixtures;

use App\Entity\Quiz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class QuizFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $quiz = new Quiz();
            $quiz->setTitle('quiz title' . $i);
            $quiz->setPercentageCorrectnessToWin(80 + $i);
            $manager->persist($quiz);
        }

        $manager->flush();
    }
}
