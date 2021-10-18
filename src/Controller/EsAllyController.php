<?php

namespace App\Controller;

use App\DataTransformer\WorkOutputDataTransformer;
use App\Dto\Beer;
use App\Dto\WorkOutput;
use App\Entity\Paragraph;
use App\Entity\Work;
use App\Repository\WorkRepository;
use JoliCode\Elastically\Client;
use Elastica\Document;
use JoliCode\Elastically\Result;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class EsAllyController extends AbstractController
{

    /**
     * @Route("/es/ally_purge", name="es_ally_purge")
     */
    public function purge(Client $client): Response
    {
        $indexBuilder = $client->getIndexBuilder();
        foreach ($client->getCluster()->getIndexNames() as $indexName) {
            $index = $client->getIndex($indexName);
            $response = $index->delete();
            dump($response);
//            $this->addFlash('notice', $response->get);
        }


//        $result = array_map(fn($name) => $indexBuilder->purgeOldIndices($name), array_keys($client->getConfig('elastically_index_class_mapping')));
//        dd($result);
        return $this->redirectToRoute('es_ally');
    }

    /**
     * @Route("/es/ally", name="es_ally")
     */
    public function browse(Client $client): Response
    {
        $indexes  = [];
        foreach ($client->getCluster()->getIndexNames() as $indexName) {
            $indexes[$indexName] = $client->getIndex($indexName);
        }

        $dump = [];
        $mappingConfig = $client->getConfig('elastically_index_class_mapping');


        $dumps = array_map(fn($obj) => ['class' => get_class($obj), 'obj' => $obj, 'keys' => array_keys((array)$obj)], $dump);

        return $this->render('es_ally/index.html.twig', [
            'indexes' => $indexes,
            'mappingConfig' => $mappingConfig,
            'dumps' => $dumps
        ]);

    }

    /**
     * @Route("/es/ally_explore/{allyIndexName}", name="es_ally_explore")
     */
    public function explore(Client $client, Request $request, $allyIndexName, WorkRepository $workRepository): Response
    {
        $dumps = [];
        $transformer = new WorkOutputDataTransformer();
        $index = $client->getIndex($allyIndexName);
        if (!$index->exists()) {
            $indexBuilder = $client->getIndexBuilder();
            $index = $indexBuilder->createIndex($allyIndexName);
            $indexBuilder->markAsLive($index, $allyIndexName);
        }


        $indexer = $client->getIndexer();
        if ($request->get('reindex')) {
            // Set the proper aliases
            switch ($allyIndexName) {
                case 'works':
                    foreach ($workRepository->findAll() as $work) {
                        $dto = $transformer->transform($work, WorkOutput::class, []);
                        $_id = $work->getId();
                        $indexer->scheduleIndex($allyIndexName,  new Document($_id, $dto));
                    }
                    $indexer->flush();
            }
        }
        $query = $request->get('q', 'night');
        $mapping = $index->getMapping();
        $results = array_map(fn (Result $result) => $result->getModel(), $index->search($query)->getResults());
        /*
        $indexName = $client->getIndexNameFromClass(Work::class);
        array_push($dump, $results);
        */

        return $this->render('es_ally/explore.html.twig', [
            'index' => $index,
            'results' => $results,
            'mapping' => $mapping,
            'dumps' => $dumps
        ]);

    }

    /**
     * @Route("/es/ally_example", name="es_ally_example")
     */
    public function example(Client $client): Response
    {

        $dump = [];

// Class to build Indexes
        $indexBuilder = $client->getIndexBuilder();

// Create the Index in Elasticsearch
        $index = $indexBuilder->createIndex('beers');

// Set the proper aliases
        $indexBuilder->markAsLive($index, 'beers');

// Class to index DTO in an Index
        $indexer = $client->getIndexer();

        $dto = new Beer();
        $dto->bar = 'American Pale Ale';
        $dto->foo = 'Hops from Alsace, France';

// Add a document to the queue
        $_id = Uuid::v4()->toBase32();
        $indexer->scheduleIndex('beers', new Document($_id, $dto));
        $indexer->flush();

// Set parameters on the Bulk
        $indexer->setBulkRequestParams([
            'pipeline' => 'covfefe',
            'refresh' => 'wait_for'
        ]);

// Force index refresh if needed
        $indexer->refresh('beers');

// Get the Document (new!)
        $results = $client->getIndex('beers')->getDocument($_id);
array_push($dump, $results);
// Get the DTO (new!)
        $results = $client->getIndex('beers')->getModel($_id);
        array_push($dump, $results);

// Perform a search
        $results = $client->getIndex('beers')->search('alsace');
        array_push($dump, $results);

// Get the Elastic Document
        $doc = $results->getDocuments()[0];
        array_push($dump, $doc);

// Get the Elastica compatible Result
        $result = $results->getResults()[0];
        array_push($dump, $result);

// Get the DTO 🎉 (new!)
        $model =  $results->getResults()[0]->getModel();
        array_push($dump, $model);

// Create a new version of the Index "beers"
        try {
            $index = $indexBuilder->createIndex('beers');
            array_push($dump, $index);
        } catch (\Exception $e) {
            array_push($dump, $e);
        }

// Slow down the Refresh Interval of the new Index to speed up indexation
        $indexBuilder->slowDownRefresh($index);
        $indexBuilder->speedUpRefresh($index);

// Set proper aliases
        $indexBuilder->markAsLive($index, 'beers');

// Clean the old indices (close the previous one and delete the older, this is for versioning
        $indexBuilder->purgeOldIndices('beers');

// Mapping change? Just call migrate and enjoy a full reindex (use the Task API internally to avoid timeout)
        if (0) {
            $newIndex = $indexBuilder->migrate($index);
            $indexBuilder->speedUpRefresh($newIndex);
            $indexBuilder->markAsLive($newIndex, 'beers');
        }
        $dumps = array_map(fn($obj) => ['class' => get_class($obj), 'obj' => $obj, 'keys' => array_keys((array)$obj)], $dump);

        return $this->render('es_ally/index.html.twig', [
            'dumps' => $dumps
        ]);
    }

}
