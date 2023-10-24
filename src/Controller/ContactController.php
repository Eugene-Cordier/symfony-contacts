<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();

        return $this->render('contact/index.html.twig', ['contacts' => $contacts,
        ]);
    }

    #[Route('/contact/{contactId}', name: 'app_contact/show')]
    public function show(ContactRepository $contactRepository, int $contactId): Response
    {
        $contact = $contactRepository->find($contactId);
        if (!$contact) {
            return $this->render('contact/show.html.twig', ['contact' => $contact]);
        } else {
            throw NotFoundHttpException("le contact n'existe pas");
        }
    }
}
