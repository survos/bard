<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/passthru/{apiRoute}", name="api_passthru")
     */
    public function passthru(Request $request, $apiRoute, UrlGeneratorInterface $urlGenerator)
    {
        // call API Platform with datatables parameters
        // https://datatables.net/manual/server-side

        $params = $request->query->all();
        /*
         *                 params = oldData(params); // remove junk
                var apiData = $(this).data('query-params') || {},
                    columns = _.map(params.columns, function (c) {
                        var column = c.name || c.data;
                        if (c.search.value) {
                            apiData[column] = c.search.value;
                        }
                        return column;
                    });
                apiData.itemsPerPage = params.length;
                console.log('------',apiData.itemsPerPage, params.length);
                if (params.start) {
                    apiData.page = Math.floor(params.start / params.length) + 1;
                }
                if (params.search && params.search.value) {
                    apiData.q = params.search.value;
                }
                if (params.order) {
                    apiData.order = {};
                    params.order.forEach(function (o) {
                        var name = columns[o.column]; // translate number to name
                        apiData.order[name] = o.dir;
                    });
                }

         */

        $draw = $request->get('draw', 1);

        // hack for testing
        $start = $params['start'] ?? 1;
        $length = $params['length'] ?? 15;

        $apiUrl = $urlGenerator->generate($apiRoute, [
            'itemsPerPage' => $length,
            'page' => $draw],
            UrlGeneratorInterface::ABSOLUTE_URL);



        $passthru = $apiUrl; // $request->get('path'); // the API Platform path, e.g. route api_works_get_collection
        // curl -X GET "https://bard.survos.com.wip/api/works?page=1" -H  "accept: application/ld+json"

        // dd($params, $start, $length, $passthru);

        $hydra = $this->fetchUrl($passthru);

        // convert the hydra JSON to DataTable JSON


        $dtJson = $this->hydraToDTJson($hydra, $draw);
        $dtJson = array_merge(['apiUrl' => $passthru], $dtJson);

        return new JsonResponse($dtJson);




        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    private function fetchUrl($url, $options=[])
    {
        $client = HttpClient::create();

        $options = [
            'headers' => ['accept: application/ld+json']
        ];
        if (strstr($url,'.wip')) {
            $options['proxy'] = '127.0.0.1:7080';
        }
         // dd($options, $url);

        $response = $client->request('GET', $url, );

        $statusCode = $response->getStatusCode();
// $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
// $contentType = 'application/json'
        $content = $response->getContent();
// $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();


        return $content;
    }

    private function hydraToDTJson($hydra, $draw)
    {
        $data = [
            'draw' => $draw,
            'recordsTotal' => $hydra['hydra:totalItems'],
            'recordsFiltered' => $hydra['hydra:totalItems'], // count($hydra['hydra:member']),
            'data' => $hydra['hydra:member'],
        ];
        return $data;

        dd($hydra, $data);
        /*
        data.data = data['hydra:member'];
        delete data['hydra:member'];
                    data.draw = params.draw;
                    data.recordsTotal = data['hydra:totalItems']; // real value not available?
                    data.recordsFiltered = data['hydra:totalItems'];
                    delete data['hydra:totalItems'];
                    delete data['hydra:view'];
                    delete data['@context'];
                    delete data['@id'];
                    delete data['@type'];
                    callback(data);
        */
    }
}
