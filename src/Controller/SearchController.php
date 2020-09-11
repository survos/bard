<?php

namespace App\Controller;

use App\DataTransformer\WorkOutputDataTransformer;
use App\Dto\WorkOutput;
use App\Entity\Work;
use App\Form\SearchFormType;
use App\Repository\WorkRepository;
use Elastica\Client;
use Elastica\Document;
use Elastica\Index;
use Elastica\Mapping;
use Elastica\Result;
use Elastica\Search;
use FOS\ElasticaBundle\Finder\FinderInterface;
use FOS\ElasticaBundle\Index\IndexManager;
use FOS\ElasticaBundle\Manager\RepositoryManager;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/search")
 */

class SearchController extends AbstractController
{

    const INDEX_NAME='work_output';

    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    private $searchDSN;

    private $indexName;

    public function __construct(LoggerInterface $logger, SerializerInterface $serializer, $searchDSN)
    {
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->searchDSN = $searchDSN;
        $this->indexName = self::INDEX_NAME; // ??
    }

    private $client;
    public function getClient(): Client
    {
        if (empty($this->client)) {
            $this->client = new Client($this->searchDSN);
            $this->client->setLogger($this->logger);

        }
        return $this->client;
    }

    public function getIndex(): Index
    {
        $index = $this->getClient()->getIndex($this->indexName);
        return $index;
    }

    public function getSearch(): Search
    {
        $search = new Search($this->getClient());
        $search->addIndex($this->indexName);
        return $search;
    }

    /**
     * @Route("/api-dt", name="search_api_dt")
     */
    public function apiDataTable(Request $request)
    {
        // uses api platform with ElasticSearch.


    }

    /**
     * @Route("/search", name="search_dashboard")
     */
    public function search(Request $request,
                           RepositoryManagerInterface $repositoryManager,
                           FinderInterface $finderParagraph, FinderInterface $finderWork, IndexManager $indexManager)
    {
        $q = $request->get('q', 'night');
        $index = $indexManager->getIndex('work');
        // Option 1. Returns all users who have example.net in any of their mapped fields

//        $results = $finderParagraph->find($q);
        $results = $repositoryManager->getRepository('paragraph')->find($q);

        dd($finderWork);
        $index = $indexManager->getDefaultIndex();
        dd($indexManager->getDefaultIndex());
        $search = new Work();
        $works = [];
        $rawResults = [];

        if ($term = $request->get('q')) {
            $index = $this->getIndex();
            // manual way, where we call the search directly.  We call elasticSearch elsewhere.
            $resultSet = $index->search($term);
            $rawResults = array_map(function (Result $result) { return $result->getHit(); }, $resultSet->getResults());

            $works = array_map(function (Result $result) use ($rawResults) {
                $data = $result->getHit()['_source'];
                array_push($rawResults, $data);

                $data = json_encode($result->getHit()['_source']);

                $work = $this->serializer->deserialize($data, WorkOutput::class, 'json');
                return $work;
            }, $resultSet->getResults());
        }


        $form = $this->createForm(SearchFormType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($term = $form->get('q')->getData()) {
                return $this->redirectToRoute('search_dashboard', ['q'=> $term]);
            }
        }

        $index = $this->getIndex();
        try {
            $mapping = $index->getMapping();
        } catch (\Exception $e) {
            $mapping = null;
        }
        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'searchServer' => $this->searchDSN,
            'mapping' => $mapping,
            'works' => $works,
            'q' => $term,
            'rawResults' => $rawResults,
            'controller_name' => 'SearchController',
        ]);
    }

    /**
     * @Route("/create-index", name="search_create_index")
     */
    public function runIndex(WorkRepository $workRepository, NormalizerInterface $normalizer)
    {
        $index = $this->getIndex();
        $index->create([], true);

        // @todo, automatic this from annotations
        $mapping = new Mapping([
                'chapterCount' => ['type' => 'integer'],
                'full_text' => ['type' => 'text'],
                'fountainUrl' => ['type' => 'keyword'],
                'GenreType' => ['type' => 'keyword'],
                'source' => ['type' => 'keyword'],
                'id' => ['type' => 'keyword'],
                'year' => ['type' => 'integer'],

                ]
        );
        $index->setMapping($mapping);
        // return $this->redirectToRoute('search_dashboard');
        // dd($mapping, $index);

        // let's try it with the 'play'
        $playIndex = $index; // $this->getIndex();

        foreach ($workRepository->findBy([], [], 100) as $idx => $work) {
            // defined by the serializer, the read group of 'Work'

            /* Option 1: serialize 'Work' and index it.  The problem is that this may not work with API Platform
            $data = $normalizer->normalize($work, 'json', ['groups' => ['read']]);
            $doc = new Document($work->getId(), $data);
            // dd($data);
            $index->addDocument($doc);
            */

            // Option 2: transform the data to WorkOutput, index it.  Then use API Platform to READ
            $workOutput = (new WorkOutputDataTransformer())
                ->transform($work, WorkOutput::class, []);
            $workOutputData = $normalizer->normalize($workOutput, 'json', ['groups' => ['read', 'full_text']]);
            // dd($workOutput, $workOutputData);
            $doc = new Document($idx, $workOutputData);
            $playIndex->addDocument($doc);
        }

        $this->addFlash('notice', "Index created");
        return $this->redirectToRoute('search_dashboard', ['q' => 'henry']);

    }

    /**
     * @Route("/search", name="search")
     */
    public function mapping(Request $request, WorkRepository $workRepository, NormalizerInterface $normalizer)
    {

    }

}
