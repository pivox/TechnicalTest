<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitProjectCommand extends Command
{
    protected static $defaultName = 'init-project';

    protected function configure()
    {
        $this
            ->setDescription('initilize the project ')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        $io->writeln("Initilizing project on process");

        $command = $this->getApplication()->find('doctrine:database:drop');
        $commandInput  = new ArrayInput(["--force" => true, '--if-exists' => true]);
        $returnCode = $command->run($commandInput, $output);

        $command = $this->getApplication()->find('doctrine:database:create');
        $commandInput  = new ArrayInput(["-n" => true]);
        $returnCode = $command->run($commandInput, $output);

        $command = $this->getApplication()->find('doctrine:migration:migrate');
        $commandInput  = new ArrayInput([]);
        $commandInput->setInteractive(false);
        $returnCode = $command->run($commandInput, $output);

        $command = $this->getApplication()->find('doctrine:fixtures:load');
        $commandInput  = new ArrayInput([]);
        $commandInput->setInteractive(false);
        $returnCode = $command->run($commandInput, $output);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

    }
}
