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
            'fichier' => '',
            'file' => ''
        ]);
    }

    /**
     * @Route("/neescarre", name="neescarre")
     */
    public function neescarre(): Response
    {
        return $this->render('artmath/ness_carre.html.twig', [
            'file' => '', 
        ]);
    }
    
    /**
     * @Route("/koch", name="koch")
     */
    public function koch(): Response
    {
        return $this->render('artmath/koch.html.twig', [
            'fichier' => '',
    
        ]);
    }

    /**
     * @Route("/vortex", name="vortex")
     */
    public function vortex(): Response
    {
        return $this->render('artmath/vortex.html.twig', [
            'figure' => '',
    
        ]);
    }


    /**
     * @Route("/cr", name="cr")
     */
    public function cr(): Response
    {
        return $this->render('artmath/cr.html.twig', [
        ]);
    }



    /**
     * @Route("/calculer", name="calculer")
     */
    public function calculer(Request $request): Response
    {
        // Récupère les paramètres issus du formulaire (on indique le champ name)
        $dimension = $request -> request -> get("dimension") ;
        // Pour les boutons : si appui contenu champ value sinon NULL
        $calculer  = $request -> request -> get("calculer");
        $imprimer  = $request -> request -> get("imprimer");


        // Oui : Appelle le script Python koch.py qui se trouve dans le répertoire /public
        $process = new Process(['python3','koch.py',$dimension]);
        $process -> run();
        // Récupère la valeur de retour renvoyé par le script python
        $fichier="reponse.svg";

        // Retourne un message si l'éxécution c'est mal passée
        if (!$process->isSuccessful())
            return new Response ("Erreur lors de l'éxécution du script Python :<br>".$process->getErrorOutput());    

        // A t'on appuyé sur calculer ?
        if ($calculer!=NULL)
            return $this->render('artmath/koch.html.twig', [
                'fichier' => $fichier,
            ]);
        else {
            // On a appuyé sur imprimer
            return $this->render('artmath/imprimer.html.twig', [
                'fichier' => $fichier,
            ]);
        }
    }

        //----------------------------------Partie de la 2eme Figure----------------------
        /**
        * @Route("/calculer2", name="calculer2")
        */
        public function calculer2(Request $request): Response
        {
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
        $file="reponse.png";
        
        // Retourne un message si l'éxécution c'est mal passée
        if (!$run->isSuccessful())
            return new Response ("Erreur lors de l'éxécution du script Python :<br>".$run->getErrorOutput());    


        // A t'on appuyé sur calculer ?
        if ($cree!=NULL)
            return $this->render('artmath/ness_carre.html.twig', [
                'file' => $file,
            ]);
        else {
            // On a appuyé sur imprimer
            return $this->render('artmath/print_nees.html.twig', [
                'file' => $file,
                ]);
        }
        }
        
        /**
        * @Route("/calcul_vortex", name="calcul_vortex")
        */
        public function calcul_vortex(Request $request): Response
        {
            // Récupère les paramètres issus du formulaire (on indique le champ name)
    
        $cercle1_rayon = $request -> request -> get("cercle1_rayon") ;
        $espaces = $request -> request -> get("espaces") ;
        $traits = $request -> request -> get("traits") ;
        $angle = $request -> request -> get("angle") ; 
    
        // Pour les boutons : si appui contenu champ value sinon NULL
        $generer  = $request -> request -> get("generer");
        $printer  = $request -> request -> get("printer");
            
        // Oui : Appelle le script Python vortex.py qui se trouve dans le répertoire /public
        $gen = new Process(['python3','vortex.py',$cercle1_rayon, $espaces, $traits, $angle]);
        $gen -> run();
        // Récupère la valeur de retour renvoyé par le script python
        $figure="vortex.png";
            
        // Retourne un message si l'éxécution c'est mal passée
        if (!$gen->isSuccessful())
            return new Response ("Erreur lors de l'éxécution du script Python :<br>".$gen->getErrorOutput());    
    
    
        // A t'on appuyé sur calculer ?
        if ($gen!=NULL)
            return $this->render('artmath/vortex.html.twig', [
                'figure' => $figure,
            ]);
        else {
            // On a appuyé sur imprimer
            return $this->render('artmath/print_vortex.html.twig', [
                'figure' => $figure,
                ]);
        }
        }
}           
        