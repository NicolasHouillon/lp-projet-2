<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @IsGranted("ROLE_USER", message="Vous ne pouvez pas accéder à cette page.")
     * @Route("/profile", name="profile")
     * @return Response
     */
    public function profile(): Response {
        return $this->render('user/profile.html.twig');
    }

}
