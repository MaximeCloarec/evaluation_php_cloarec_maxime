<?php

namespace App\Repository;

use App\Database\Mysql;
use App\Entity\Users;

class UsersRepository
{
    private \PDO $connexion;

    public function __construct()
    {
        $this->connexion = (new Mysql())->connectBdd();
    }

    public function saveUser(Users $user): void
    {
        $request = "INSERT INTO users (firstname,lastname,email,`password`) VALUES (?,?,?,?)";
        $req = $this->connexion->prepare($request);

        $req->bindValue(1, $user->getFirstname(), \PDO::PARAM_STR);
        $req->bindValue(2, $user->getLastname(), \PDO::PARAM_STR);
        $req->bindValue(3, $user->getEmail(), \PDO::PARAM_STR);
        $req->bindValue(4, $user->getPassword(), \PDO::PARAM_STR);

        $req->execute();
    }

    public function isUserExistsByEmail(string $email): bool
    {
        $request = "SELECT id_users AS id FROM users WHERE email = ?";
        $req = $this->connexion->prepare($request);

        $req->bindParam(1, $email, \PDO::PARAM_STR);

        $req->execute();

        $data = $req->fetch(\PDO::FETCH_ASSOC);
        if (!empty($data)) {
            return true;
        }
        return false;
    }

    public function findUserByEmail(string $email): Users
    {
        $request = "SELECT id_users AS id, firstname, lastname, email, `password`
        FROM users WHERE email = ?";
        $req = $this->connexion->prepare($request);
        $req->bindParam(1, $email, \PDO::PARAM_STR);
        $req->execute();
        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Users::class);
        $user = $req->fetch();
        return $user;
    }
}
