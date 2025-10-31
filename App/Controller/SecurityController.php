<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\SecurityService;
use Mithridatem\Validation\Exception\ValidationException;

class SecurityController
{
    private readonly SecurityService $securityService;

    public function __construct()
    {
        $this->securityService = new SecurityService();
    }

    public function renderRegister(?string $title, array $data = []): void
    {
        include __DIR__ . "/../../templates/template_register.php";
    }

    public function renderLogin(?string $title, array $data = []): void
    {
        include __DIR__ . "/../../templates/template_login.php";
    }


    public function register()
    {
        if (isset($_POST["submit"])) {
            try {
                $this->securityService->register(new Users($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password"]));
                $data["succes"] = "Vous êtes bien enregistré !";
            } catch (ValidationException $e) {
                $data["error"] = $e->getMessage();
            }
        }
        $this->renderRegister("Register", $data ?? []);
    }

    public function login()
    {
        if (isset($_POST["submit"])) {
            try {
                $user = new Users();
                $user->setEmail($_POST["email"]);
                $user->setPassword($_POST["password"]);
                $this->securityService->login($user);
                $data["succes"] = "Vous êtes bien connecté !";
            } catch (ValidationException $e) {
                $data["error"] = $e->getMessage();
            }
        }
        $this->renderLogin("Login", $data ?? []);
    }

    public function logout(): void
    {
        $this->securityService->logout();
    }
}
