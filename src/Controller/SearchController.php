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
use Elastica\Search;
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

    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(LoggerInterface $logger, SerializerInterface $serializer)
    {
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    private $client;
    const INDEX_NAME='work_output';
    public function getClient(): Client
    {
        if (empty($this->client)) {
            $this->client = new Client();
            $this->client->setLogger($this->logger);

        }
        return $this->client;
    }

    public function getIndex($indexName=self::INDEX_NAME): Index
    {
        $index = $this->getClient()->getIndex($indexName);
        return $index;
    }

    public function getSearch(): Search
    {
        $search = new Search($this->getClient());
        $search->addIndex($this->indexName);
        return $search;
    }

    /**
     * @Route("/search", name="search_dashboard")
     */
    public function index(Request $request)
    {
        $search = new Work();

        if ($term = $request->get('q')) {
            // $index = $this->getIndex();
            $index = $this->getIndex();
            $resultSet = $index->search($term);
            dump($resultSet->getResults());
            foreach ($resultSet->getResults() as $result) {
                dump($result);

                $data = $result->getHit()['_source'];
                dd($data);
                $data = json_encode($result->getHit()['_source']);


                $work = $this->serializer->deserialize($data, WorkOutput::class, 'json');
                dd($work, $data);
            }

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
            'mapping' => $mapping,
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

        $mapping = new Mapping([
                'chapterCount' => ['type' => 'integer'],
                'full_text' => ['type' => 'text'],
                'fountainUrl' => ['type' => 'keyword'],
                'GenreType' => ['type' => 'keyword'],
                'id' => ['type' => 'keyword'],

                ]
        );
        $index->setMapping($mapping);
        // return $this->redirectToRoute('search_dashboard');
        // dd($mapping, $index);

        foreach ($workRepository->findBy([], [], 10) as $idx => $work) {
            $data = $normalizer->normalize($work, 'json', ['groups' => ['read']]);
            $doc = new Document($work->getId(), $data);
            // dd($data);
            $index->addDocument($doc);

            // let's try it with the 'play'
            $playIndex = $this->getIndex();

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
