<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuizRepository")
 */
class Quiz
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="quiz", orphanRemoval=true)
     */
    private $questions;

    /**
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 3,
     *      max = 220
     * )
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\Range(
     *      min = 1,
     *      max = 100,
     *      minMessage = "Min value is {{ limit }}",
     *      maxMessage = "Max value is {{ limit }}"
     * )
     *
     * @ORM\Column(type="integer")
     */
    private $percentageCorrectnessToWin;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            if ($question->getQuiz() === $this) {
                $question->setQuiz(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPercentageCorrectnessToWin(): ?int
    {
        return $this->percentageCorrectnessToWin;
    }

    public function setPercentageCorrectnessToWin(int $percentageCorrectnessToWin): self
    {
        $this->percentageCorrectnessToWin = $percentageCorrectnessToWin;

        return $this;
    }
}
