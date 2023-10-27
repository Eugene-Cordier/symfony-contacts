<?php

namespace App\Controller;

use App\Entity\Contact;
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

    #[Route('/contact/{id}', name: 'app_contact/show', requirements: ['contactId' => '\d+'])]
    public function show(contact $contact): Response
    {
        return $this->render('contact/show.html.twig', ['contact' => $contact]);
    }
}
