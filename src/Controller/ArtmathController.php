<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtmathController extends AbstractController
{
    /**
     * @Route("/artmath", name="app_artmath")
     */
    public function index(): Response
    {
        return $this->render('artmath/index.html.twig', [
            'controller_name' => 'ArtmathController',
        ]);
    }
}
