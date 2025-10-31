<?php

namespace App\Service;

use App\Repository\CategoryRepository;

class CategoryService
{
    private readonly CategoryRepository $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository;
    }

    public function getAllCategory(): array
    {
        return $this->categoryRepository->findAll();
    }
}
