<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Quiz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class QuizFixtures extends Fixture implements OrderedFixtureInterface
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

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder(): int
    {
        return 1;
    }
}
