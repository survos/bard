<?php

namespace App\Controller;

use App\Services\LiquidService;
use Liquid\Tag\TagComment;
use Liquid\Tag\TagIf;
use Liquid\Tag\TagInclude;
use Liquid\Variable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class LiquidController extends AbstractController
{
    private function liquidToTwig(string $filename)
    {

    }
    #[Route('/liquid', name: 'liquid')]
    public function index(LiquidService $liquidService, ParameterBagInterface $bag): Response
    {
        $protectedPath = sprintf("%s/liquid/protected/", $bag->get('kernel.project_dir'));
        assert(file_exists($protectedPath), "missing dir $protectedPath");

        $liquidService->toTwig($protectedPath . 'templates');


        dd($liquid, $liquid->getRoot(), $liquidTemplate);

        echo $liquid->render($assigns);

        return $this->render('liquid/index.html.twig', [
            'controller_name' => 'LiquidController',
        ]);
    }
}
