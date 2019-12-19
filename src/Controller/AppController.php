<?php

namespace App\Controller;

use App\Repository\WorkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/app", name="app")
     */
    public function index(WorkRepository $workRepository)
    {
        return $this->render('app/index.html.twig', [
            'works' => $workRepository->findAll()
        ]);
    }
}
