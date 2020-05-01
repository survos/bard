<?php

namespace App\Controller;

use App\Repository\WorkRepository;
use App\Services\AppService;
use Doctrine\ORM\EntityManagerInterface;
use EasyRdf\Graph;
use EasyRdf\Parser\RdfXml;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/app", name="app")
     * @Route("/home", name="home")
     * @Route("/", name="app_homepage")
     */
    public function index(WorkRepository $workRepository)
    {
        return $this->render('app/index.html.twig', [
            'works' => $workRepository->findAll()
        ]);
    }

    /**
     * @Route("/rdf", name="test_rdf")
     */
    public function rdf(AppService $appService, EntityManagerInterface $em)
    {
        $rdfUrl =  'http://www.gutenberg.org/ebooks/10001.rdf';
        /*
        $pgBook = new Graph($rdfUrl);
        dd($pgBook);
        */

        $localUrl =  __DIR__ . '/../../public/pg10001.rdf';
        $localBaseUri = 'http://www.gutenberg.org/ebooks/10001.kindle.images';
        // $localUrl =  __DIR__ . '/../../public/foaf.rdf';

        $foafUrl = 'http://127.0.0.1:8001/foaf.rdf';
        $foafBaseUri = 'http://njh.me/foaf.rdf';
       // $localUrl = 'http://127.0.0.1:8001/pg10001.rdf';
        $format = 'rdfxml';
        $xmlParser = new RdfXml();

        foreach (glob(__DIR__ . '/../../public/pg?????.rdf') as $url) {
    /*
        foreach ([
                    // 'http://njh.me/foaf.rdf' => 'http://njh.me',
                     $localUrl => $localBaseUri,
                     // $foafUrl => $foafBaseUri,

                 ] as $url=>$baseUri) {



            $graphViaLoad = new Graph($url);
            // $graphViaLoad->load();
            dump($graphViaLoad->type());
            */

            $contents = file_get_contents($url);

            if (!$book = $appService->createBook($url, $contents, $checkFirst = true))
            {
                // warn?
            }


            // return new Response($graph->dump());
            /*
            $dc = $graph->all('dc', 'title');
            dd($dc);
            // $graph->load();
            // $response = $graph->parse($contents, $format, $baseUri);
            $graphDump = $graph->dump('text');
            return $graphDump;
            $book = $graph->all();
            dd($book);
            if (!$book) {
                dd($graph, '$book is not set.');
            }

            // $response = $xmlParser->parse($graph, $contents, 'rdfxml', $baseUri);
            dump($url, $baseUri, $response, $graph);
            */
            echo "<hr />";
        }

        $em->flush();
        dd('stopped');


        $baseUrl = 'http://www.gutenberg.org/ebooks/10001';


        $url = "http://njh.me/foaf.rdf";
        /*
        $foaf = new Graph($url);
        $foaf->load();
        $me = $foaf->primaryTopic();
        // $me is set!
        */

        $contents = trim(file_get_contents($url));
        $graph = new Graph($url, $contents, $format);

        $response = $graph->parse($contents, $format, $url);
        // dd($graph->getUri());

        $me = $graph->primaryTopic();
        if (!$me) { die('$me is not set when loading via parser.');} // but this works
        // $me is null


        return "My name is: " . $me->get('foaf:name') . "\n";
        dd($me, $graph);


        return $this->render('app/index.html.twig', [
            'url' => $url
        ]);
    }

}
