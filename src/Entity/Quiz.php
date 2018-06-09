<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentageCorrectnessToWin;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId()
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
            // set the owning side to null (unless already changed)
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

    // TODO to test !
    public function shallowComparison(Quiz $mirrorQuiz): string
    {
        $answers = [];
        $mirrorAnswers = [];

        foreach ($this->getQuestions() as $question) {
            $answers[] = $question->getAnswers();
        }

        foreach ($mirrorQuiz->getQuestions() as $mirrorQuestion) {
            $mirrorAnswers[] = $mirrorQuestion->getAnswers();
        }

        $counter = \count($answers);
        $correctFeedback = 0;
        for ($i = 0; $i < $counter; $i++) {
            if ($answers[$i] === $mirrorAnswers[$i]) {
                $correctFeedback++;
            }
        }

        return (string)($correctFeedback / $counter);
    }
}
