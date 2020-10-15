<?php

namespace App\Command;

use App\Exporter\DataCollector;
use App\Exporter\WriterCsv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ExportHistoricQuestionCommand extends Command
{
    protected static $defaultName = 'export-historic-question';

    /** @var DataCollector */
    private $dataCollector;

    /** @var string*/
    private $projectDir;
    /**
     * ExportHistoricQuestionCommand constructor.
     * @param DataCollector $dataCollector
     */
    public function __construct(DataCollector $dataCollector, ParameterBagInterface $parameterBag)
    {
        parent::__construct();
        $this->dataCollector = $dataCollector;
        $this->projectDir = $parameterBag->get('kernel.project_dir');
    }


    protected function configure()
    {
        $this
            ->setDescription('Export Question Historic in a csv file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $output->writeln([
            'Exporting the table question_historic table as csv file',
            '============',
            '',
        ]);
        $fileName = 'Question_Historic_'.time().'.csv';
        $writerCsv = new WriterCsv($this->projectDir, $fileName);
        $this->dataCollector
            ->setWriter($writerCsv)
            ->init('QuestionHistoric')
            ->write()
        ;
        $output->writeln([
            ' ==> Done',
        ]);
        $io->success('You can check the file :'.$this->projectDir.'/'.$fileName);
        return 0;
    }
}
