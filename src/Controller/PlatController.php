<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @Route("/plat")
 */
class PlatController extends AbstractController
{
    /**
     * @Route("/", name="plat_index", methods={"GET"})
     * @param PlatRepository $platRepository
     * @return Response
     */
    public function index(PlatRepository $platRepository): Response
    {
        return $this->render('plat/index.html.twig', [
            'plats' => $platRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="plat_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $plat = new Plat();
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file= $plat->getImage();
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $plat->setImage($filename);
            ////////////////////////////////
            $entityManager = $this->getDoctrine()->getManager();
            $plat->setDate(new \DateTime('now'));
            $entityManager->persist($plat);
            $entityManager->flush();

            return $this->redirectToRoute('plat_index');
        }

        return $this->render('plat/new.html.twig', [
            'plat' => $plat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plat_show", methods={"GET"})
     * @param Plat $plat
     * @return Response
     */
    public function show(Plat $plat): Response
    {
        return $this->render('plat/show.html.twig', [
            'plat' => $plat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="plat_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Plat $plat
     * @return Response
     */
    public function edit(Request $request, Plat $plat): Response
    {
        $file_path=$this->getParameter('upload_directory').'/'.$plat->getImage();
        $plat->setImage(
            new File( $file_path)
        );
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            ///////////////////////////////////
            $file= $plat->getImage();
            unlink($file_path);
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $plat->setImage($filename);
            ////////////////////////////////
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plat_index', [
                'id' => $plat->getId(),
            ]);
        }

        return $this->render('plat/edit.html.twig', [
            'plat' => $plat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("front/{id}", name="plat_show_front", methods={"GET"})
     * @param Plat $plat
     * @return Response
     */
    public function showFront(Plat $plat): Response
    {
        return $this->render('plat/showFront.html.twig', [
            'plat' => $plat,
        ]);
    }
    /**
     * @Route("/{id}", name="plat_delete", methods={"DELETE"})
     * @param Request $request
     * @param Plat $plat
     * @return Response
     */
    public function delete(Request $request, Plat $plat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            $file_path=$this->getParameter('upload_directory').'/'.$plat->getImage();
            unlink($file_path);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plat_index');
    }
}
