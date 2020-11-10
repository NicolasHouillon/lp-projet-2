<?php

namespace App\Controller;

use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER", message="Vous ne pouvez pas accéder à cette page.")
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{

    /**
     * @Route("/profile", name="profile")
     * @return Response
     */
    public function profile(): Response {
        return $this->render('user/profile.html.twig');
    }

    /**
     * @Route("/edit", name="profile_edit")
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request) {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("profile");
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile/achivements", name="profile_achievements")
     * @return Response
     */
    public function achievements() {
        return $this->render('user/profile/achievements.html.twig');
    }

    /**
     * @Route("/profile/actions", name="profile_actions")
     * @return Response
     */
    public function actions() {
        return $this->render('user/profile/actions.html.twig');
    }

}
