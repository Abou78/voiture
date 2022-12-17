<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GlobalController extends AbstractController
{
    /**
     * @Route("/", name="global_accueil")
     */
    public function accueil(): Response
    {
        return $this->render('global/accueil.html.twig', [
            'controller_name' => 'GlobalController',
        ]);
    }
}
