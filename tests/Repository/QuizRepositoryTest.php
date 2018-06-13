<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class QuizRepositoryTest
 * @package App\Tests\Repository
 *
 * Before run tests, copy phpunit.xml.dist content to phpunit.xml file and complete DATABASE_URL variable.
 * Uploading fixtures is obligatory.
 */
class QuizRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testFindQuizzesByPartOfTitle(): void
    {
        $quizzes = $this->entityManager
            ->getRepository(Quiz::class)
            ->findQuizzesByPartOfTitle('title');

        $this->assertCount(10, $quizzes);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
