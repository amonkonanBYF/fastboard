<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
//use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    private  UserPasswordEncoderInterface $encoder;
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController'    
        ]);
    }
    /**
     * @Route("/api/login", name="login_check")
     */
    public function login()
    {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json([
                'error' => "Invalid login request: check that the Content-Type and Accept header is application/json."
            ], 400);
        }

        return $this->json(['user' => $this->getUser() ? $this->getUser() : null]);
    }

}
