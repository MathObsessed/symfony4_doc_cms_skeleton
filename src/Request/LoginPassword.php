<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoginPassword
{
    const LOGIN = 'login';
    const PASSWORD = 'password';

    private $login;
    private $password;
    private $validator;
    private $errors;

    public static function fromRequest(Request $request, ValidatorInterface $validator): self
    {
        $dto = new self($request->get(self::LOGIN), $request->get(self::PASSWORD), $validator);
        $dto->validate();

        return $dto;
    }

    public function login(): string
    {
        return $this->login;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function toArray(): array
    {
        return [
            self::LOGIN => $this->login,
            self::PASSWORD => $this->password,
        ];
    }

    private function __construct(string $login, string $password, ValidatorInterface $validator)
    {
        $this->login = $login;
        $this->password = $password;
        $this->validator = $validator;
    }

    private function validate(): void
    {
        $errors = [];

        $violationList = $this->validator->validate($this->toArray(), new Assert\Collection([
            self::LOGIN => [
                new Assert\NotBlank([
                    'message' => 'Login may not be blank'
                ]),
                new Assert\Email([
                    'message' => 'Login must be a valid email'
                ])
            ],
            self::PASSWORD => [
                new Assert\NotBlank([
                    'message' => 'Password may not be blank'
                ]),
                new Assert\Length([
                    'min' => 6,
                    'minMessage' => 'Password should be at least {{ limit }} characters long',
                    'max' => 4096, // max length allowed by Symfony for security reasons
                    'maxMessage' => 'Password should be no longer than {{ limit }} characters'
                ])
            ]
        ]));

        if (count($violationList) > 0) {
            foreach ($violationList as $error) {
                /** @var ConstraintViolation $error */
                $errors[] = $error->getMessage();
            }
        }

        $this->errors = $errors;
    }
}
