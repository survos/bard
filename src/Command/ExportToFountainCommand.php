<?php

namespace App\Command;

use App\Repository\WorkRepository;
use App\Services\AppService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExportToFountainCommand extends Command
{
    protected static $defaultName = 'app:export-to-fountain';
    /**
     * @var WorkRepository
     */
    private WorkRepository $workRepository;
    /**
     * @var AppService
     */
    private AppService $appService;

    public function __construct(WorkRepository $workRepository, AppService $appService, $name = null)
    {
        parent::__construct($name);
        $this->workRepository = $workRepository;
        $this->appService = $appService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Export plays to fountain, for import into Role Playhouse')
            ->addArgument('dir', InputArgument::OPTIONAL, 'Directory', '/home/tac/sa/data/bard')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $dir = $input->getArgument('dir');

        if ($dir) {
            $io->note(sprintf('Writing to: %s', $dir));
        }

        foreach ($this->workRepository->findAll() as $work) {
            file_put_contents($fn = sprintf('%s/%s.fountain', $dir, $work->getId()), $this->appService->workToFountain($work));
            $io->note(sprintf('Writing to: %s', $fn));
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
