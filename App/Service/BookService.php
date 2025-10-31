<?php

namespace App\Service;

use Mithridatem\Validation\Exception\ValidationException;
use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\UsersRepository;
use COM;

class BookService
{
    private readonly BookRepository $bookRepository;
    private readonly UsersRepository $usersRepository;

    public function __construct()
    {
        $this->bookRepository = new BookRepository;
        $this->usersRepository = new UsersRepository;
    }

    public function saveBookToUser(Book $book): void
    {
        if (empty($_SESSION["users"])) {
            throw new ValidationException("Vous devez être connecté !");
        }

        $book->setUser($this->usersRepository->findUserByEmail($_SESSION["users"]->getEmail()));

        if (empty($book->getTitle()) || empty($book->getAuthor()) || empty($book->getDescription()) || empty($book->getPublicationDate()) || empty($book->getCategory())) {
            throw new ValidationException("Tout les champs doivent être remplis");
        }

        try {
            $this->bookRepository->saveBook($book);
        } catch (ValidationException) {
            throw new ValidationException("Une erreur est survenue lors de l'enregistrement de l'utilisateur");
        }
    }

    public function getAllBooks(): array
    {
        try {
            return $this->bookRepository->findAll();
        } catch (ValidationException) {
            throw new ValidationException("Une erreur est survenue");
        }
    }
}
