<?php

namespace App\Controller;

use App\Service\DocumentService;
use App\Service\SecurityService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class DefaultController extends AbstractController
{
    /**
     * @Route("/{vueRoute}", requirements={"vueRoute"="^(?!api|_(profiler|wdt)).*"}, name="app_homepage")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'title' => $this->getParameter('page_title'),
            'login' => (!empty($this->getUser()) ? $this->getUser()->getUsername() : '')
        ]);
    }

    /**
     * @Route("/api/login", name="api_login")
     */
    public function login(): JsonResponse
    {
        return $this->json([
            'login' => $this->getUser()->getUsername()
        ]);
    }

    /**
     * @Route("/api/logout", name="api_logout")
     */
    public function logout(): void
    {
        // controller can be blank: it will never be executed!
    }

    /**
     * @param Request $request
     * @param SecurityService $securityService
     * @return JsonResponse
     * @Route("/api/register", name="api_register")
     */
    public function register(Request $request, SecurityService $securityService): JsonResponse
    {
        try {
            $securityService->registerUser($request);
        } catch (CustomUserMessageAuthenticationException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
                'errors' => $e->getMessageData()
            ], Response::HTTP_BAD_REQUEST);
        } catch (UniqueConstraintViolationException $e) {
            return new JsonResponse([
                'message' => 'Email is taken'
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse();
    }

    /**
     * @param DocumentService $documentService
     * @return JsonResponse
     * @Route("/api/documents", name="api_documents")
     */
    public function documents(DocumentService $documentService): JsonResponse
    {
        if (empty($this->getUser())) {
            return new JsonResponse(null, Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse($documentService->findAll());
    }
}
