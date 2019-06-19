<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Request\LoginPassword;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityService extends AbstractGuardAuthenticator
{
    private $entityManager;
    private $passwordEncoder;
    private $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
    }

    public function getCredentials(Request $request)
    {
        $dto = LoginPassword::fromRequest($request, $this->validator);
        $errors = $dto->errors();

        if (count($errors) > 0) {
            throw new CustomUserMessageAuthenticationException('Validation errors', $errors);
        }

        return $dto->toArray();
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($exception instanceof CustomUserMessageAuthenticationException) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
                'errors' => $exception->getMessageData()
            ], Response::HTTP_UNAUTHORIZED);
        } else {
            return new JsonResponse([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
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

        return $this->passwordEncoder->isPasswordValid($user, $credentials[LoginPassword::PASSWORD]);
    }

    public function start(Request $request, AuthenticationException $exception = null)
    {
        return new Response('', Response::HTTP_UNAUTHORIZED);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var UserRepository $repository */
        $repository = $this->entityManager->getRepository(User::class);
        $user = $repository->findByEmail($credentials[LoginPassword::LOGIN]);

        if (!$user) {
            throw new AuthenticationException('Email "'.$credentials[LoginPassword::LOGIN].'" not found');
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

    /**
     * @param Request $request
     * @throws CustomUserMessageAuthenticationException
     * @throws UniqueConstraintViolationException
     */
    public function registerUser(Request $request): void
    {
        $dto = LoginPassword::fromRequest($request, $this->validator);
        $errors = $dto->errors();

        if (count($errors) > 0) {
            throw new CustomUserMessageAuthenticationException('Validation errors', $errors);
        }

        $user = new User();
        $user->setEmail($dto->login());
        $user->setPassword($this->passwordEncoder->encodePassword($user, $dto->password()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
