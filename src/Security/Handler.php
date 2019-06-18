<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class Handler extends AbstractGuardAuthenticator
{
    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCredentials(Request $request)
    {
        return [
            'login' => $request->request->get('login'),
            'password' => $request->request->get('password')
        ];
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($exception instanceof CustomUserMessageAuthenticationException) {
            return new JsonResponse([ 'message' => $exception->getMessage() ], Response::HTTP_UNAUTHORIZED);
        } else {
            return new JsonResponse([ 'message' => 'Invalid credentials' ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if (!($user instanceof User)) {
            throw new AuthenticationException('User object must be of type '.User::class);
        }

        if (!$user->getApproved()) {
            throw new CustomUserMessageAuthenticationException('Account requires approval');
        }

        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function start(Request $request, AuthenticationException $exception = null)
    {
        return new RedirectResponse('/login');
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['login']]);

        if (!$user) {
            throw new AuthenticationException('Email "'.$credentials['login'].'" not found');
        }

        return $user;
    }

    public function supports(Request $request)
    {
        return (
            ($request->attributes->get('_route') === 'api_login') &&
            $request->isMethod('POST') &&
            ($request->getContentType() === 'json')
        );
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
