<?php

namespace App\Controller;

use App\Entity\Ingrediant;
use App\Form\IngrediantType;
use App\Repository\IngrediantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ingrediant")
 */
class IngrediantController extends AbstractController
{
    /**
     * @Route("/", name="ingrediant_index", methods={"GET"})
     * @param IngrediantRepository $ingredientRepository
     * @return Response
     */
    public function index(IngrediantRepository $ingredientRepository): Response
    {
        return $this->render('ingrediant/index.html.twig', [
            'ingrediants' => $ingredientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ingrediant_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $ingrediant = new Ingrediant();
        $form = $this->createForm(IngrediantType::class, $ingrediant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ingrediant);
            $entityManager->flush();

            return $this->redirectToRoute('ingrediant_index');
        }

        return $this->render('ingrediant/new.html.twig', [
            'ingrediant' => $ingrediant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ingrediant_show", methods={"GET"})
     * @param Ingrediant $ingrediant
     * @return Response
     */
    public function show(Ingrediant $ingrediant): Response
    {
        return $this->render('ingrediant/show.html.twig', [
            'ingrediant' => $ingrediant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ingrediant_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Ingrediant $ingrediant
     * @return Response
     */
    public function edit(Request $request, Ingrediant $ingrediant): Response
    {
        $form = $this->createForm(IngrediantType::class, $ingrediant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ingrediant_index', [
                'id' => $ingrediant->getId(),
            ]);
        }

        return $this->render('ingrediant/edit.html.twig', [
            'ingrediant' => $ingrediant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ingrediant_delete", methods={"DELETE"})
     * @param Request $request
     * @param Ingrediant $ingrediant
     * @return Response
     */
    public function delete(Request $request, Ingrediant $ingrediant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingrediant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ingrediant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ingrediant_index');
    }
}
