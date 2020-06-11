<?php

namespace App\Command;

use App\Entity\Work;
use App\Repository\ParagraphRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FixDatabaseCommand extends Command
{
    protected static $defaultName = 'app:fix-database';
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ParagraphRepository
     */
    private $paragraphRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(EntityManagerInterface $em, ParagraphRepository $paragraphRepository, LoggerInterface $logger, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->paragraphRepository = $paragraphRepository;
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('chapters', null, InputOption::VALUE_NONE, 'Reset Chapters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $repo = $this->em->getRepository(Work::class);

        foreach ($repo->findAll() as $work) {

            // fix the relationship between paragraphs and chapters
            /** @var $work Work */
            if ($input->getOption('chapters')) {
                $io->note("Updating chapter paragraphs");
                $this->fix($work);
                $this->em->flush();
            }

            // fix the html characters, mostly quotes
            foreach ($work->getChapters() as $chapter) {
                $chapter->setDescription($this->fixText($chapter->getDescription()));
                foreach ($chapter->getParagraphs() as $paragraph) {
                    $paragraph->setPlainText($this->fixText($paragraph->getPlainText()));
                }
            }
            $this->em->flush();
        }

        $io->success('Database updated.');

        return 0;
    }

    // fix the bad chapter references
    public function fix(Work $work) {
        $this->logger->info(' fixing ' . $work->getShortTitle());
        foreach ($work->getChapters() as $chapter) {
            $sceneParagraphs = [];
            foreach ($this->paragraphRepository->findByChapter($chapter) as $paragraph) {
                // $chapter->addParagraph($paragraph);
                $paragraph->setScene($chapter);
                array_push($sceneParagraphs, $paragraph);
            }

            // store json paragraphs to Chapter if sqlite won't work on heroku, to avoid 10K line limit

        }
        return $work;
    }

    public function fixWorkText(Work $work) {
        foreach ($work->getChapters() as $chapter) {
            $chapter->setDescription($this->fixText($chapter->getDescription()));
        }

        return $work;
    }

    private function fixText($s) {
        return str_replace('&#8217;', "'", $s);
    }


}
