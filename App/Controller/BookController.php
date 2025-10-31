<?php

namespace App\Controller;

use App\Entity\Book;
use App\Service\BookService;
use App\Service\CategoryService;
use Mithridatem\Validation\Exception\ValidationException;

class BookController
{
    private readonly  BookService $bookService;
    private readonly CategoryService $categoryService;

    public function __construct()
    {
        $this->bookService = new BookService;
        $this->categoryService = new CategoryService;
    }

    public function renderRegisterBook(?string $title, array $data = [], array $category): void
    {
        include __DIR__ . "/../../templates/template_registerBook.php";
    }

    public function renderShowAllBook(?string $title, array $data = [], array $books = []): void
    {
        include __DIR__ . "/../../templates/template_books.php";
    }


    public function addBookToUsers()
    {
        if (isset($_POST["submit"])) {
            try {
                $book = new Book();
                $book->setTitle($_POST["title"]);
                $book->setDescription($_POST["description"]);
                $book->setPublicationDate($_POST["date"]);
                $book->setAuthor($_POST["author"]);
                $book->getCategory()->setId($_POST["category"]);
                $this->bookService->saveBookToUser($book);
            } catch (ValidationException $e) {
                $data["error"] = $e->getMessage();
            }
        }
        $this->renderRegisterBook("Add Book", $data ?? [], $this->categoryService->getAllCategory());
    }

    public function showAllBooksUsers()
    {
        if (isset($_SESSION["users"])) {
            try {
                $books = $this->bookService->getAllBooks();
            } catch (ValidationException $e) {
                $data["error"] = $e->getMessage();
            }
        } else {
            $data["error"] = "Vous devez être connecté";
        }
        $this->renderShowAllBook("All my books ", $data ?? [], $books ?? []);
    }
}
