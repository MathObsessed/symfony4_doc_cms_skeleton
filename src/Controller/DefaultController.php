<?php

namespace App\Controller;

use App\Security\Handler;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
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

    /**
     * @Route("/api/register", name="api_register")
     */
    public function register(Request $request, Handler $securityHandler)
    {
        $response = new JsonResponse();

        try {
            $securityHandler->registerUser($request->get('login'), $request->get('password'));
        } catch (UniqueConstraintViolationException $e) {
            $response = new JsonResponse([ 'message' => 'Email is taken' ]);
        } catch (\Exception $e) {
            $response = new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }
}
