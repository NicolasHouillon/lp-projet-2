<?php

namespace App\Controller;

use App\Database\Database;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
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
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function index(Request $request, CommentRepository $commentRepository): Response
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
            $return["comments"] = $commentRepository->findAll();
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
        $db = $request->get('database');

        $connexion = new Database(strtolower($db), $this->getUser());

        $resultat = $connexion->requestQuery($requete);

        return new JsonResponse($resultat);
    }

    /**
     * @Route("/training/solution", name="solution", options={"expose"=true})
     * @param Request $request
     * @return Response
     */
    public function solution(Request $request): Response
    {
        $db = $request->get('database');
        $sujet = $request->get('sujet');
        $question = $request->get('question');
        $sousSujet = $request->get('sousSujet');
        $file = 'exercices/'.strtolower($db).'/'.strtolower($sujet). '/' . strtolower($sujet) . '.json';

        if(file_exists($file) === true) {
            $data = file_get_contents($file);
            $obj = json_decode($data, true);
            $key = array_search($question, $obj['exercices'][$sousSujet]['questions']);
            if ($key !== false) {
                $requete = $obj['exercices'][$sousSujet]['requetes'][$key];

                $connexion = new Database(strtolower($db), $this->getUser());

                $resultat = $connexion->requestQuery($requete);

                return new JsonResponse($resultat);
            }
        }
        return new JsonResponse();
    }

}
