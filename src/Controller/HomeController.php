<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {

        $file = 'exercices/sujets.json';
        $data = file_get_contents($file);
        $obj = json_decode($data, true);

        return $this->render('home/index.html.twig',[
            'sujets' => $obj
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
