<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\DocumentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{
    private $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('default/register.html.twig', [
            'pageTitle' => $this->getParameter('page_title'),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{vueRoute}", requirements={"vueRoute"="^(?!api|_(profiler|wdt)).*"}, name="app_homepage")
     */
    public function index()
    {
        return $this->render('base.html.twig', [
            'title' => $this->getParameter('page_title'),
            'login' => (!empty($this->getUser()) ? $this->getUser()->getUsername() : '')
        ]);
    }

    /**
     * @Route("/api/login", name="api_login")
     */
    public function login()
    {
        return $this->json([
            'login' => $this->getUser()->getUsername()
        ]);
    }

    /**
     * @Route("/api/logout", name="api_logout")
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
    }
}
