<?php

namespace App\Controller;

use App\Repository\WorkRepository;
use Elastica\Client;
use Elastica\Document;
use Elastica\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(Request $request, WorkRepository $workRepository, NormalizerInterface $normalizer)
    {
        $term = $request->get('term', 'Henry');
        $max = 3000;
        $client = new Client();
        $index = $client->getIndex($indexName = 'bard');

        foreach ($workRepository->findBy([], [], $max) as $work) {
            $data = $normalizer->normalize($work, 'json', ['groups' => ['read']]);
            $doc = new Document($work->getId(), $data);
            $index->addDocument($doc);
        }

        $search = new Search($client);
        $search->addIndex($indexName);

        // Refresh index
        $index->refresh();

        $resultSet = $index->search($term);

        dd($resultSet->getResponse()->getData());
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
}
