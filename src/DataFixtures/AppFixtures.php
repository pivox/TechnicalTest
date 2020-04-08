<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $question = $this->getQuestion();
        $manager->persist($question);
        foreach ($question->getAnswers() as $answer) {
            $manager->persist($answer);
        }

        $manager->flush();
    }

    private function getQuestion(): Question
    {
        $question = new Question();
        return $question->setTitle('toto')
            ->setStatus(Question::STATUS_PUBLISHED)
            ->setPromoted(true)
            ->addAnswer($this->getAnswer($question));
            ;
    }

    private function getAnswer(Question $question): Answer
    {
        $answer = new Answer();

        return $answer->setChannel(Answer::CHANNEL_FAQ)
            ->setBody('test body 1');
    }
}
