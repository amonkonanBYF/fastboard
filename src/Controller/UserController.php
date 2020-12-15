<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $registerForm = $this->createForm(RegisterType::class, $user);

        $registerForm->handleRequest($request);

        $user->setDateCreated(new \DateTime());

        $user->setRoles(["ROLE_USER"]);

        if($registerForm->isSubmitted() && $registerForm->isValid())
        {
            $encoded = $encoder->encodePassword($user,$user->getPassword());

            $user->setPassword($encoded);

            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "Your account has been created");

            return $this->redirectToRoute('profile');

        }

        return $this->render('user/index.html.twig', [
            'registerForm'=>$registerForm->createView()
        ]);
    }

    /**
     * @Route("/connect", name="connect")
     *
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        if($this->getUser()){
            $user = $this->getUser();
            dump($user);
            return $this->redirectToRoute('profile',['user' => $user]);
        }
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('user/login.html.twig', [
            'error'=>$error
        ]);
    }

    /**
     * @Route("/profile/{user}", name="profile")

     */
    public function getUserProfile($user)
    {
        if($this->getUser($user)) {
            $user = $this->getUser();
            dump($this->getUser());
        }
        dump($this->getUser());
        return $this->render('user/profile.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){}
}
