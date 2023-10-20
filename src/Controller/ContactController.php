<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $contactRepository, int $id): Response
    {
        $product = $contactRepository->findBy($id,$id);
        if (!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }
        return $this->render('contact/index.html.twig', [
        ]);
    }
}
