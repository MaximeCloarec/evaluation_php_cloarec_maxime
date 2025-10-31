<?php

namespace App\Repository;

use App\Database\Mysql;
use App\Entity\Category;

class CategoryRepository
{
    private \PDO $connexion;

    public function __construct()
    {
        $this->connexion = (new Mysql())->connectBdd();
    }

    public function findAll(): array
    {
        $request = "SELECT id_category AS id, name FROM category";
        $req = $this->connexion->prepare($request);
        $req->execute();
        return $req->fetchAll(\PDO::FETCH_CLASS, Category::class);
    }
}
