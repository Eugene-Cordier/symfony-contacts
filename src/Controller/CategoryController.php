<?php

namespace App\Controller;

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
        $categories= $categoryRepository->findBy([],['name'=> 'ASC']);
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
