<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response
     */
    public function index(): Response
    {
        $dirs = scandir("exercices/" );
        array_splice($dirs, 0, 2);
        $dirs = array_map(fn($dir) => ucfirst($dir), $dirs);

        return $this->render('home/index.html.twig',[
            'databases' => $dirs
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }

    /**
     * @Route("/team", name="team")
     */
    public function team(): Response
    {
        return $this->render('home/team.html.twig');
    }

    /**
     * @Route("/sujets", name="sujets", options={"expose"=true})
     * @param Request $request
     */
    public function obtenirSujet(Request $request)
    {
        $database = $request->get('database');

        $dirs = scandir("exercices/" . $database);
        array_splice($dirs, 0, 2);
        $dirs = array_map(fn($dir) => ucfirst($dir), $dirs);

        return new JsonResponse($dirs);
    }

}
