<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(Request $request): Response
    {
        $db = $request->get('db') ?? 'mysql';
        $dirs = scandir("exercices/" . $db);
        array_splice($dirs, 0, 2);
        $dirs = array_map(fn($dir) => ucfirst($dir), $dirs);

        return $this->render('home/index.html.twig',[
            'sujets' => $dirs
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

}
