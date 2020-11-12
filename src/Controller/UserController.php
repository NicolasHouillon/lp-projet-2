<?php

namespace App\Controller;

use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

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

    /**
     * @Route("/profile/delete", name="profile_delete")
     * @param Request $request
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function delete(Request $request, SessionInterface $session) {
        $submittedToken = $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-account', $submittedToken)) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $em->remove($user);
            $em->flush();
            $this->get('security.token_storage')->setToken(null);
            $session->invalidate();
            $this->addFlash("success", "Votre compte a bien été supprimé. Toutes vos données le sont également.");
            return $this->redirectToRoute("home");
        } else {
            $this->addFlash("danger", "Une erreur est survenue. Veulliez réessayer plus tard.");
            return $this->redirectToRoute("home");
        }
    }

}
