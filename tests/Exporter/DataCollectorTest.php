<?php


namespace App\Tests\Exporter;


use App\Entity\Question;
use App\Entity\QuestionHistoric;
use App\Exporter\DataCollector;
use App\Exporter\WriterCsv;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class DataCollectorTest
 * @package App\Tests\Exporter
 */
class DataCollectorTest extends TestCase
{
    /** @var DataCollector */
    private $dataCollectorTest;

    /** @var MockObject */
    private $entityManager;

    /** @var MockObject */
    private $writer;

    /**
     *
     */
    public function setUp()
    {
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->writer = $this->createMock(WriterCsv::class);
        $this->dataCollectorTest = new DataCollector($this->entityManager);
        $this->dataCollectorTest->setWriter($this->writer);
    }

    /**
     * @throws \ReflectionException
     */
    public function testInit()
    {
        $repository = $this->createMock(ObjectRepository::class);
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn([new QuestionHistoric()]);
        $this->entityManager
            ->expects($this->once())
            ->method('getRepository')
            ->willReturn($repository)
            ;
        $dataCollectorTest = $this->dataCollectorTest->init('QuestionHistoric');
        $this->assertInstanceOf(DataCollector::class, $dataCollectorTest);
    }

    /**
     * @return Question
     */
    public function getQuestionHistoric()
    {
        $question = new Question();
        $question
            ->setStatus(Question::STATUS_PUBLISHED)
            ->setPromoted(true)
            ->setTitle("title phpunit")
            ;
        $questionHistoric = new QuestionHistoric();
        $questionHistoric->setNewTitle($question->getTitle())
            ->setOldTitle($question->getTitle().'old');
        $questionHistoric->setNewTitle($question->getTitle())
            ->setOldTitle($question->getTitle().'old')
            ->setQuestion($question);

        return $question;
    }
}