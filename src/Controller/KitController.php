<?php

namespace App\Controller;

use App\Entity\Kit;
use App\Form\KitType;
use App\Repository\KitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/kit")
 */
class KitController extends AbstractController
{
    /**
     * @Route("/", name="kit_index", methods={"GET"})
     * @param KitRepository $kitRepository
     * @return Response
     */
    public function index(KitRepository $kitRepository): Response
    {
        return $this->render('kit/index.html.twig', [
            'Kits' => $kitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="kit_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $kit = new Kit();
        $form = $this->createForm(KitType::class, $kit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file= $kit->getImage();
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $kit->setImage($filename);
            ////////////////////////////////
            $entityManager = $this->getDoctrine()->getManager();
            $kit->setCreatedAt(new \DateTime('now'));
            $entityManager->persist($kit);
            $entityManager->flush();

            return $this->redirectToRoute('kit_index');
        }

        return $this->render('kit/new.html.twig', [
            'kit' => $kit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("front/{id}", name="kit_show_front", methods={"GET"})
     * @param Kit $kit
     * @return Response
     */
    public function showFront(Kit $kit): Response
    {
        return $this->render('kit/showFront.html.twig', [
            'kit' => $kit,
        ]);
    }

    /**
     * @Route("/{id}", name="kit_show", methods={"GET"})
     * @param Kit $kit
     * @return Response
     */
    public function show(Kit $kit): Response
    {
        return $this->render('kit/show.html.twig', [
            'kit' => $kit,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="kit_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Kit $kit
     * @return Response
     */
    public function edit(Request $request, Kit $kit): Response
    {
        $file_path=$this->getParameter('upload_directory').'/'.$kit->getImage();
        $kit->setImage(
            new File( $file_path)
        );
        $form = $this->createForm(KitType::class, $kit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            ///////////////////////////////////
            $file= $kit->getImage();
            unlink($file_path);
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $kit->setImage($filename);
            ////////////////////////////////
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('kit_index', [
                'id' => $kit->getId(),
            ]);
        }

        return $this->render('kit/edit.html.twig', [
            'kit' => $kit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="kit_delete", methods={"DELETE"})
     * @param Request $request
     * @param Kit $kit
     * @return Response
     */
    public function delete(Request $request, Kit $kit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$kit->getId(), $request->request->get('_token'))) {
            $file_path=$this->getParameter('upload_directory').'/'.$kit->getImage();
            if ($file_path != "")
            {
                unlink($file_path);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($kit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('kit_index');
    }
}
