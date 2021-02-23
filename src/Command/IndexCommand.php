<?php

namespace App\Command;

use App\Dto\Headline;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\HeadlineSearchService;
use App\Transformers\ArticleDataTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Elastica\Document;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class IndexCommand extends Command
{
    protected static $defaultName = 'app:index';
    private NormalizerInterface $normalizer;
    private EntityManagerInterface $entityManager;

    public function __construct(
                                NormalizerInterface $normalizer,
                                EntityManagerInterface $entityManager,
                                string $name = null)
    {
        parent::__construct($name);
        $this->normalizer = $normalizer;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Submit entities to ElasticSearch indexer')
            ->addArgument('entity', InputArgument::OPTIONAL, 'Class name of Doctrine Entity type to index')
            ->addArgument('groups', InputArgument::OPTIONAL, 'Serialization Groups')
            ->addArgument('dto', InputArgument::OPTIONAL, 'Class name of DTO?')
            ->addOption('reset', null, InputOption::VALUE_NONE, 'Purge and re-create index first')
            ->addOption('id', null, InputOption::VALUE_OPTIONAL, 'entity id (for testing one item', null)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('entity');



        $index = $this->searchService->getIndex();
        $index->create([], true);
        $index->setMapping($this->searchService->getMapping());
        if ($input->getOption('reset')) {
        }

        $perPage = 100;
        $total = $this->articleRepository->count([]);
        $offset = 0;


        // $paginator = new Paginator($);
        while ($offset < $total ) {
            $docs = [];
            $qb = $this->articleRepository->createQueryBuilder('a')
                ->orderBy('a.id', 'DESC');
                // ->where('a.marking in (:marking)')
                // ->setParameter('marking', Article::WEBSITE_PLACES);

            if ($id = $input->getOption('id')) {
                $qb->andWhere("a.id =$id");
                $offset = 0;
            } else {
                $qb
                    ->setMaxResults($perPage)
                    ->setFirstResult($offset);
            }
            // dd($qb->getQuery()->getSQL());
            // $paginator = new Paginator($qb->getQuery());

            /**
             * @var  $idx
             * @var Article $article
             */
            foreach ($qb->getQuery()->getResult() as $idx => $article) {


                $headline = (new ArticleDataTransformer())
                    ->transform($article, Headline::class, []);
                if (count($headline->tag_ids)) {
                    // dd($headline);
                }

                $headlineData = $this->normalizer->normalize($headline, 'json', ['groups' => ['search']]);
                try {
                // dd($headlineData);
                // if ($idx == 1) { dump($headlineData); }
                $doc = new Document($headline->id, $headlineData);
                $index->addDocument($doc);
                // array_push($docs, $doc);
            } catch (\Exception $exception) {
                $io->error($exception->getMessage());
                dump($headlineData);
                $io->error(sprintf("Error indexing article $idx, ID: %d", $article->getId())) ;
                continue;
            }
        }
            $offset += $perPage;
            if (count($docs)) {
                // $index->addDocuments($docs);
            }
            dump($offset);
            $index->refresh();
            // dump($headline);

        }
        $io->success("All $offset of $total articles have been indexed.");  // get a count to prove it!!

        return 0;
    }
}
