<?php

namespace App\Controller;


use App\Entity\Kit;
use App\Entity\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/panier")
 */
class PanierController extends AbstractController
{

    /**
     * @Route("/add/{id}",name="panier_add")
     * @return Response
     */
    public function index(Request $request, $id):Response
    {
        $article = $this->getDoctrine()
            ->getRepository($request->get('class'))
            ->find($id);
        if($article){
            $panier = $this->get('session')->get('panier') ?? [];
            array_push($panier, ['article' => $article, 'quantity' => $request->get('quantity')]);
            $this->get('session')->set('panier', $panier);
            return $this->json(['result' => true]);
        }

        return $this->json(['result' => false]);
    }

    /**
     * @Route("/",name="panier_show")
     * @return Response
     */
    public function show(Session $session):Response
    {
        $panier = $session->get('panier');
        return $this->render("panier/index.html.twig", compact('panier'));
    }



}