<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventController extends AbstractController
{
    // Admin route: List events (only for admins)
    #[Route('/admin/event', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    // Admin route: Create new event (only for admins)
    #[Route('admin/event/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                // Create a safe name for the file
                $fileName = uniqid('', true) . '.' . $imageFile->guessExtension();

                // Move the file to the uploads folder
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads',
                    $fileName
                );

                // Save the file name into the database
                $event->setImage($fileName);
            }
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }


    // Admin route: Edit event (only for admins)
    #[Route('admin/event/edit/{id}', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                // Create a safe name for the file
                $fileName = uniqid('', true) . '.' . $imageFile->guessExtension();

                // Move the file to the uploads folder
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads',
                    $fileName
                );

                // Save the file name into the database
                $event->setImage($fileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    // Admin route: Delete event (only for admins)
    #[Route('admin/event/delete/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('admin/event/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
    // Public route: List events (accessible to everyone)
    #[Route('/events', name: 'app_event_list_public', methods: ['GET'])]
    public function listPublic(EventRepository $eventRepository): Response
    {
        return $this->render('event/list_public.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    // Public route: Show event details (accessible to everyone)
    #[Route('/event/{id}', name: 'app_event_show_public', methods: ['GET'])]
    public function showPublic(Event $event): Response
    {
        return $this->render('event/show_public.html.twig', [
            'event' => $event,
        ]);
    }
}