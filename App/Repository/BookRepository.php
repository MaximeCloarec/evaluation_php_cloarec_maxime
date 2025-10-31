<?php

namespace App\Repository;

use App\Database\Mysql;
use App\Entity\Book;

class BookRepository
{
    private \PDO $connexion;

    public function __construct()
    {
        $this->connexion = (new Mysql())->connectBdd();
    }

    public function saveBook(Book $book): void
    {
        $request = "INSERT INTO book (title, `description`,publication_date,author,id_category,id_users) VALUES (?,?,?,?,?,?)";
        $req = $this->connexion->prepare($request);

        $req->bindValue(1, $book->getTitle(), \PDO::PARAM_STR);
        $req->bindValue(2, $book->getDescription(), \PDO::PARAM_STR);
        $req->bindValue(3, $book->getPublicationDate(), \PDO::PARAM_STR);
        $req->bindValue(4, $book->getAuthor(), \PDO::PARAM_STR);
        $req->bindValue(5, $book->getCategory()->getId(), \PDO::PARAM_INT);
        $req->bindValue(6, $book->getUser()->getId(), \PDO::PARAM_INT);

        $req->execute();
    }

    public function findAll(): array
    {
        $request = "SELECT book.id_book AS id ,book.title, book.`description`,book.publication_date AS publicationDate,book.author,category.`name` FROM users
	INNER JOIN book ON users.id_users = book.id_users
    INNER JOIN category ON book.id_category = category.id_category
    WHERE users.id_users = ?";

        $req = $this->connexion->prepare($request);

        $req->bindValue(1, $_SESSION["users"]->getId(), \PDO::PARAM_INT);

        $req->execute();
        $books = $req->fetchAll(\PDO::FETCH_CLASS, Book::class);
        foreach ($books as $book) {
            $book->getCategory()->setName($book->name);

            unset($book->name);
        }
        return $books;
    }
}
