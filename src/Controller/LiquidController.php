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
//        $protectedPath = sprintf("%s/liquid/protected/", $bag->get('kernel.project_dir'));
        $protectedPath = sprintf("/home/tac/survos/themes/tabler/src/pages");

        assert(file_exists($protectedPath), "missing dir $protectedPath");

        $templates = $liquidService->toTwig($protectedPath, 'html');

        return $this->render('liquid/templates.html.twig', [
            'templates' => $templates
        ]);
    }
}
