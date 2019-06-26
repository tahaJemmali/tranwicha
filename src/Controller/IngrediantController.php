<?php

namespace App\Controller;

use App\Entity\Ingrediant;
use App\Form\IngrediantType;
use App\Repository\IngrediantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
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
            $file= $ingrediant->getImage();
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $ingrediant->setImage($filename);
            ////////////////////////////////
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
        $file_path=$this->getParameter('upload_directory').'/'.$ingrediant->getImage();
        $ingrediant->setImage(
            new File( $file_path)
        );
        $form = $this->createForm(IngrediantType::class, $ingrediant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            ///////////////////////////////////
            $file= $ingrediant->getImage();
            unlink($file_path);
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $ingrediant->setImage($filename);
            ////////////////////////////////
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
            $file_path=$this->getParameter('upload_directory').'/'.$ingrediant->getImage();
            unlink($file_path);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ingrediant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ingrediant_index');
    }
}
