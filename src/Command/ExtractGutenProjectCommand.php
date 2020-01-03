<?php

namespace App\Command;

use App\Services\AppService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExtractGutenProjectCommand extends Command
{
    protected static $defaultName = 'app:extract-guten-project';
    /**
     * @var AppService
     */
    private $appService;

    public function __construct(AppService $appService, string $name = null)
    {
        parent::__construct($name);
        $this->appService = $appService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Read zip file and extract rdf info')
            ->addArgument('filename', InputArgument::OPTIONAL, 'Zip filename', '../data/rdf-files.tar')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $file = $input->getArgument('filename');

        if (!file_exists($file)) {
            $io->error("$file does not not exist.");
            return 1;
        }

        $this->appService->extractBz2($file);
        // $this->appService->extractZip($file);

        $io->success('File imported');

        return 0;
    }
}
