<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Quiz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class QuestionFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 100; $i++) {
            $question = new Question();
            $question->setContent('question' . $i);
            $quiz = $manager->find(Quiz::class, \mt_rand(2, 9));
            $question->setQuiz($quiz);
            $manager->persist($question);
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
        return 2;
    }
}
