<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $contactRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $contacts = $contactRepository->search($search);

        return $this->render('contact/index.html.twig', ['contacts' => $contacts,
        ]);
    }

    #[Route('/contact/{id}', name: 'app_contact/show', requirements: ['id' => '\d+'])]
    public function show(
        #[MapEntity(expr: 'repository.findWithCategory(id)')]
        Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', ['contact' => $contact]);
    }
    #[Route('/contact/{id}/update', name: 'app_contact_update', requirements: ['id' => '\d+'])]
    public function update(Contact $contact, Request $request): Response
    {
        return $this->render('contact/update.html.twig', ['contact' => $contact,
        ]);
    }
    #[Route('/contact/create/', name: 'app_contact_create')]
    public function create(ContactRepository $contactRepository, Request $request): Response
    {


        return $this->render('contact/create.html.twig',
        );
    }
    #[Route('/contact/{id}/delete', name: 'app_contact_delete', requirements: ['id' => '\d+'])]
    public function delete( Request $request, Contact $contact): Response
    {
        return $this->render('contact/delete.html.twig', ['contact' => $contact,
        ]);
    }
}
