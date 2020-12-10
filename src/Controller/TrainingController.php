<?php

namespace App\Controller;

use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{
    /**
     * @Route("/training", name="training")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $return = [];
        $sujet = $request->get('sujet');
        $database = $request->get('database');
        if($sujet === null) {
            $this->addFlash("warning", "Vous devez choisir un sujet.");
            return $this->redirectToRoute("home");
        } else {
            $file = 'exercices/'.strtolower($database).'/'.strtolower($sujet). '/' . strtolower($sujet) . '.json';
            if(file_exists($file) === false) {
                $this->addFlash("warning", "Le sujet n'est pas valide.");
                return $this->redirectToRoute("home");
            }
            $data = file_get_contents($file);
            $obj = json_decode($data, true);

            $return["database"] = $database;
            $return["sujet"] = $sujet;
            $return["exercices"] = $obj['exercices'];
        }

        return $this->render('training/index.html.twig', $return);
    }

    /**
     * @Route("/training/requete", name="requete", options={"expose"=true})
     * @param Request $request
     * @return Response
     */
    public function requete(Request $request): Response
    {
        $requete = $request->get('requete');

        $connexion = new PDO("mysql:host=192.168.1.4:6000;dbname=projet_lp_2", "root", "root");


        $resultat = $connexion->query($requete);


        return new JsonResponse($resultat->fetch());
    }

}
