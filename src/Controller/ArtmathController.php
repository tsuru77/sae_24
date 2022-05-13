<?php

/**************************************************************
 * Site symfony : Art Mathématique - courbe de koch           *
 **************************************************************
 * (c) F. BONNARDOT, 28 Février 2022                          *
 * This code is given as is without warranty of any kind.     *
 * In no event shall the authors or copyright holder be liable*
 *    for any claim damages or other liability.               *
 **************************************************************/

namespace App\Controller;

// Inclus par défaut par Symfony
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Récupération des données d'un formulaire
use Symfony\Component\HttpFoundation\Request;

// Exécution d'un process (ici fonction python)
// Doc : https://symfony.com/doc/current/components/process.html
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

// Pour renvoyer un fichier directement
use Symfony\Component\HttpFoundation\File\File;


class ArtmathController extends AbstractController
{
    /**
     * @Route("/", name="racine")
     */
    public function racine() : Response
    {
        // Redirige vers /artmath si on va sur le site sans
        //  indiquer le nom de la route
        return $this->redirectToRoute('app_artmath');
    }

    /**
     * @Route("/artmath", name="app_artmath")
     */
    public function index(): Response
    {
        return $this->render('artmath/index.html.twig', [
            'file' => '',
        ]);
    }

    /**
     * @Route("/calculer", name="calculer")
     */
    public function calculer(Request $request): Response
    {

        //----------------------------------Partie de la 2eme Figure----------------------

        // Récupère les paramètres issus du formulaire (on indique le champ name)

        $hasard = $request -> request -> get("hasard") ;
        $hasardangle = $request -> request -> get("hasardangle") ;
        $nbcolonnes = $request -> request -> get("nbcolonnes") ;
        $nblignes = $request -> request -> get("nblignes") ; 

        // Pour les boutons : si appui contenu champ value sinon NULL
        $cree  = $request -> request -> get("cree");
        $print  = $request -> request -> get("print");
        
        // Oui : Appelle le script Python nees_carre.py qui se trouve dans le répertoire /public
        $run = new Process(['python3','nees_carre.py',$hasard, $hasardangle, $nbcolonnes, $nblignes]);
        $run -> run();
        // Récupère la valeur de retour renvoyé par le script python
        
        $file = "reponse.png";
        
        // Retourne un message si l'éxécution c'est mal passée
        if (!$run->isSuccessful())
            return new Response ("Erreur lors de l'éxécution du script Python :<br>".$run->getErrorOutput());    


        // A t'on appuyé sur calculer ?
        if ($cree!=NULL)
            return $this->render('artmath/index.html.twig', [
                'file' => $file,
            ]);
        else {
            // On a appuyé sur imprimer
            return $this->render('artmath/imprimer.html.twig', [
                'file' => $file,
                ]);
        }
    }
}
