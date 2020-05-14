<?php

namespace App\Controller;

use App\Entity\Work;
use App\Form\WorkType;
use App\Repository\ParagraphRepository;
use App\Repository\WorkRepository;
use App\Services\AppService;
use Doctrine\ORM\EntityManagerInterface;
use Survos\LandingBundle\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/work")
 */
class WorkController extends BaseController
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
     * @Route("/html-only", name="work_html_index", methods={"GET"})
     * @Route("/html-plus-datatable", name="work_index", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $em, WorkRepository $workRepository): Response
    {
        $works = $workRepository->findAll();
        return $this->render('work/index.html.twig', [
            'works' => $works,
            'apply_basic_datatable' => $request->get('_route') === 'work_index'
        ]);
    }

    /**
     * @Route("/doctrine-datatable", name="work_doctrine_datatable", methods={"GET"})
     */
    public function doctrineDatatable(Request $request, EntityManagerInterface $em, WorkRepository $workRepository): Response
    {
        return $this->render('work/datatable.html.twig', [

        ]);
    }

    /**
     * @Route("/es-datatable", name="work_es_datatable", methods={"GET"})
     */
    public function esDatatable(Request $request): Response
    {
        return $this->render('work/es_datatable.html.twig', [

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
     * @Route("/characters/{id}", name="work_characters", methods={"GET"}, options={"expose": true})
     */
    public function characters(Work $work, AppService $appService): Response
    {
        return $this->render('work/characters.html.twig', [
            'work' => $work,
            'characters' =>  $appService->getCharacters($work)
        ]);
    }

    /**
     * @Route("/chapters/{id}", name="work_chapters", methods={"GET"}, options={"expose": true})
     */
    public function chapters(Work $work): Response
    {
        return $this->render('work/chapters.html.twig', [
            'work' => $work,
            'chapters' => $work->getChapters()
        ]);
    }

    /**
     * @Route("/show/{id}", name="work_show", methods={"GET"}, options={"expose": true})
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
     * @Route("/text/{id}", name="work_text", methods={"GET"})
     */
    public function text(Work $work, AppService $appService): Response
    {
        return $this->render('work/text.html.twig', [
            'work' => $work,
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
