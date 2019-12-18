<?php

namespace App\Controller;

use App\Entity\Work;
use App\Form\WorkType;
use App\Repository\ParagraphRepository;
use App\Repository\WorkRepository;
use App\Services\AppService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/work")
 */
class WorkController extends AbstractController
{
    /**
     * @var ParagraphRepository
     */
    private $paragraphRepository;

    public function __construct(ParagraphRepository $paragraphRepository)
    {
        $this->paragraphRepository = $paragraphRepository;
    }

    /**
     * @Route("/", name="work_index", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $em, WorkRepository $workRepository): Response
    {
        $works = $workRepository->findAll();
        if ($request->get('fix')) {
            foreach ($works as $work) {
                $this->fix($work);
                $em->flush();
            }
        }

        if ($request->get('fix')) {
            foreach ($works as $work) {
                $this->fixWorkText($work);
                $em->flush();
            }
        }


        return $this->render('work/index.html.twig', [
            'works' => $works,
        ]);
    }

    /**
     * @Route("/new", name="work_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $work = new Work();
        $form = $this->createForm(WorkType::class, $work);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($work);
            $entityManager->flush();

            return $this->redirectToRoute('work_index');
        }

        return $this->render('work/new.html.twig', [
            'work' => $work,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/show/{id}", name="work_show", methods={"GET"})
     */
    public function show(Work $work, AppService $appService): Response
    {
        $fountain = $appService->workToFountain($work);

        return $this->render('work/show.html.twig', [
            'work' => $work,
            'fountain' => $fountain
        ]);
    }

    /**
     * @Route("/fountain/{id}.{_format}", name="work_fountain", methods={"GET"})
     */
    public function fountain(Work $work, AppService $appService, $_format='txt'): Response
    {
        $fountain = $appService->workToFountain($work);

        $response = new Response(
            $fountain,
            Response::HTTP_OK,
            ['content-type' => 'text/plain']
        );

        return $response;


    }

    /**
     * @Route("/{id}/edit", name="work_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Work $work): Response
    {
        $form = $this->createForm(WorkType::class, $work);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('work_index');
        }

        return $this->render('work/edit.html.twig', [
            'work' => $work,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="work_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Work $work): Response
    {
        if ($this->isCsrfTokenValid('delete'.$work->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($work);
            $entityManager->flush();
        }

        return $this->redirectToRoute('work_index');
    }
}
