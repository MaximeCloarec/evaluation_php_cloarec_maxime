<?php

namespace App\Service;

use Mithridatem\Validation\Exception\ValidationException;
use App\Entity\Users;
use App\Repository\UsersRepository;


class  SecurityService
{
    private readonly UsersRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UsersRepository;
    }

    public function register(Users $user): void
    {
        if (empty($user->getFirstname()) || empty($user->getLastname()) || empty($user->getEmail()) || empty($user->getPassword())) {
            throw new ValidationException("Tout les champs doivent être remplis");
        };

        if ($this->userRepository->isUserExistsByEmail($user->getEmail())) {
            throw new ValidationException("L'utilisateur existe déja en BDD");
        };

        $user->hashPassword();

        try {
            $this->userRepository->saveUser($user);
        } catch (ValidationException) {
            throw new ValidationException("Une erreur est survenue lors de l'enregistrement de l'utilisateur");
        };
    }

    public function login(Users $user): void
    {
        if (empty($user->getEmail()) || empty($user->getPassword())) {
            throw new ValidationException("Tout les champs doivent être remplis");
        };

        $newUser = $this->userRepository->findUserByEmail($user->getEmail());

        if (!$newUser) {
            throw new ValidationException("L'utilisateur n'existe pas");
        }

        if (!$newUser->passwordVerify($user->getPassword())) {
            throw new ValidationException("Mot de passe incorrect");
        }

        $_SESSION["users"] = $newUser;

        return;
    }

    public function logout(): void
    {
        session_destroy();
        header("Location: /login");
    }
}
