<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        if($sujet === null) {
            $this->addFlash("warning", "Vous devez choisir un sujet.");
            return $this->redirectToRoute("home");
        } else {
            $file = 'exercices/mysql/'.$sujet. '/' . $sujet . '.json';
            if(file_exists($file) === false) {
                $this->addFlash("warning", "Le sujet n'est pas valide.");
                return $this->redirectToRoute("home");
            }
            $data = file_get_contents($file);
            $obj = json_decode($data, true);

            $return["sujet"] = $sujet;
            $return["exercices"] = $obj['exercices'];
            $return["comments"] = $commentRepository->findAll();
        }
        return $this->render('training/index.html.twig', $return);
    }
}
