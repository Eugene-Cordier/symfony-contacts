<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(Request $request, CategoryRepository $categoryRepository): Response
    {
        //$categories = $categoryRepository->findBy([], ['name' => 'ASC']);
        $search = $request->query->get('findAllAlphabeticallyWithContactCount', '');
        $categories = $categoryRepository->findAllAlphabeticallyWithContactCount($search);
        dump($categories);
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show')]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', ['category' => $category]);
    }
}
