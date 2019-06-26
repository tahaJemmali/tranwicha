<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\KitRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/",name="Home")
     * @param KitRepository $kit
     * @param PlatRepository $plat
     * @param ArticleRepository $article
     * @return Response
     */

    public function index(KitRepository $kit,PlatRepository $plat,ArticleRepository $article)
    {
        $Kits=$kit->findAll();
        $plats=$plat->findAll();
        $articles=$article->findAll();
        return $this->render('base.html.twig',compact('Kits','plats','articles'));
    }

}