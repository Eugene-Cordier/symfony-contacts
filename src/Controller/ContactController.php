<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/contact/{id}/update', name: 'app_contact_update', requirements: ['id' => '\d+'])]
    public function update(EntityManagerInterface $entityManager, Contact $contact, Request $request): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contact/show', ['id' => $contact->getId()]);
        }

        return $this->render('contact/update.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/contact/create/', name: 'app_contact_create')]
    public function create(ContactRepository $contactRepository, Request $request): Response
    {
        $contact = new contact();
        $form = $this->createForm(ContactType::class, $contact);

        return $this->render('contact/create.html.twig', [
                'contact' => $contact,
                'form' => $form,
            ]
        );
    }

    #[Route('/contact/{id}/delete', name: 'app_contact_delete', requirements: ['id' => '\d+'])]
    public function delete(Request $request, Contact $contact): Response
    {
        return $this->render('contact/delete.html.twig', ['contact' => $contact,
        ]);
    }
}
