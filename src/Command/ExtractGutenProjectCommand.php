<?php

namespace App\Command;

use App\Entity\Book;
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
            ->addOption('limit', null, InputOption::VALUE_REQUIRED, 'Files to Extract', 10)
            ->addOption('batchSize', null, InputOption::VALUE_REQUIRED, 'Flush Batch Size', 100)
        ;
    }

    private function getUrl($url) {
        return file_get_contents($url);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $file = $input->getArgument('filename');

        if (!file_exists($file)) {
            $io->error("$file does not not exist.");
            return 1;
        }
        $output = __DIR__ . '/../../public';
        $this->appService->extractBz2($file, [
            'limit' =>  $input->getOption('limit'),
            'batchSize' =>  $input->getOption('batchSize'),
            'outputDirectory' => __DIR__ . '/../../public/',
        ]);

        /* moved to controller, service, etc.
        $rdf = 'http://www.gutenberg.org/cache/epub/10001/pg10001.rdf';
        $rdfXml = file_get_contents(__DIR__ . '/../../pg10001.rdf');

        \EasyRdf\RdfNamespace::set('mo', 'http://purl.org/ontology/mo/');

        \EasyRdf\RdfNamespace::set('subject', 'purl.org/dc/terms/subject');
        \EasyRdf\TypeMapper::set('pgterms:ebook', Book::class);

            $graph = new \EasyRdf\Graph();
            $rdfParser = new \EasyRdf\Parser\RdfXml();
            $rdfParser->parse($graph, $rdfXml, 'rdfxml', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
            $book = $graph->getUri();
            dd($graph, $book);
        try {
        } catch (\Exception $e) {
            echo $rdfXml;
            echo $e->getMessage();
        }
        dd($graph);
        */


        // $this->appService->extractZip($file);

        $io->success('File imported');

        return 0;
    }
}
