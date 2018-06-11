<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AnswerFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 950; $i++) {
            $answer = new Answer();
            $answer->setContent('answer content ' . $i);
            $answer->setIsCorrect(\mt_rand(0, 1) == 1);
            $question = $manager->find(Question::class, \mt_rand(1, 99));
            $answer->setQuestion($question);
            $manager->persist($answer);
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
        return 3;
    }
}
