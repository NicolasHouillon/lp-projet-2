<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $sujet = $request->get('sujet');
        $file = 'exercices/mysql/'.$sujet. '/' . $sujet . '.json';
        $data = file_get_contents($file);
        $obj = json_decode($data, true);

        $exercices = $obj['exercices'];

//        $questions = $obj['exercices'][$exercice]['questions'];


        return $this->render('training/index.html.twig', [
            'sujet' => $obj,
            'exercices' => $exercices
        ]);
    }
}
