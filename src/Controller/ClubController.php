<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\User;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ClubController extends AbstractController
{
    // Admin route: List clubs (only for admins)
    #[Route('/admin/club', name: 'app_club_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(ClubRepository $clubRepository, Request $request): Response
    {
        $search = $request->query->get('search');
        $clubs = $search
            ? $clubRepository->createQueryBuilder('c')
                ->where('c.name LIKE :search')
                ->setParameter('search', '%' . $search . '%')
                ->getQuery()
                ->getResult()
            : $clubRepository->findAll();

        return $this->render('club/index.html.twig', ['clubs' => $clubs]);
    }

    // Admin route: Create new club (only for admins)
    #[Route('/admin/club/new', name: 'app_club_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $fileName = uniqid('', true) . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads',
                    $fileName
                );
                $club->setImage($fileName);
            }
            $entityManager->persist($club);
            $entityManager->flush();

            return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('club/new.html.twig', [
            'club' => $club,
            'form' => $form->createView(),
        ]);
    }

    // Admin route: Edit club (only for admins)
    #[Route('/admin/club/{id}/edit', name: 'app_club_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Club $club, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $fileName = uniqid('', true) . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads',
                    $fileName
                );
                $club->setImage($fileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('club/edit.html.twig', [
            'club' => $club,
            'form' => $form->createView(),
        ]);
    }

    // Admin route: Delete club (only for admins)
    #[Route('/admin/club/{id}', name: 'app_club_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Club $club, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $club->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($club);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
    }

    // Admin route: Show club details (only for admins)
    #[Route('/admin/club/{id}', name: 'app_club_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show(Club $club): Response
    {
        return $this->render('club/show.html.twig', [
            'club' => $club,
        ]);
    }

    // Public route: List clubs (accessible to everyone)
    #[Route('/clubs', name: 'app_club_show2', methods: ['GET'])]
    public function show2(ClubRepository $clubRepository): Response
    {
        return $this->render('club/club.html.twig', [
            'clubs' => $clubRepository->findAll(),
        ]);
    }

    // Public route: Show club details (accessible to everyone)
    #[Route('/club/{id}', name: 'app_club_show_details', methods: ['GET'])]
    public function showDetails(Club $club, EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findBy(['club' => $club]);
        return $this->render('club/show_details.html.twig', [
            'club' => $club,
            'events' => $events,
        ]);
    }

    // Public route: Join club (restricted to logged-in users)
    #[Route('/club/join/{id}', name: 'app_club_join', methods: ['GET'])]
    public function join(Club $club, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('You must be logged in to join a club.');
        }
        $club->addMember($user);
        $entityManager->persist($club);
        $entityManager->flush();

        $this->addFlash('success', 'You have joined ' . $club->getName() . '!');
        return $this->redirectToRoute('app_club_show2');
    }
}