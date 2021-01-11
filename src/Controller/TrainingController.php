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
            $return["user"] = $this->getUser();
        }

        return $this->render('training/index.html.twig', $return);
    }

    /**
     * @Route("/training/requete", name="requete", options={"expose"=true})
     * @param Request $request
     * @return Response
     */
    public function requete(Request $request, UserRepository $userRepository): Response
    {
        $requete = $request->get('requete');
        $db = $request->get('database');
        $user = $userRepository->find($request->get('user'));

        $connexion = new Database(strtolower($db), $user);

        $resultat = $connexion->requestQuery($requete);

        return new JsonResponse([$resultat, $user]);
    }

}
