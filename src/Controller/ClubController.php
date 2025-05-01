<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Event;
use App\Repository\EventRepository;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('admin/club')]
#[IsGranted('ROLE_ADMIN')]
final class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club_index', methods: ['GET'])]
    public function index(ClubRepository $clubRepository, Request $request): Response
    {
        $search = $request->query->get('search'); // Get the 'search' query parameter

        if ($search) {
            $clubs = $clubRepository->createQueryBuilder('c')
                ->where('c.name LIKE :search')
                ->setParameter('search', '%' . $search . '%')
                ->getQuery()
                ->getResult();
        } else {
            $clubs = $clubRepository->findAll();
        }

        return $this->render('club/index.html.twig', [
            'clubs' => $clubs,
        ]);
    }

    #[Route('/addClub', name: 'app_club_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club);
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
                $club->setImage($fileName);
            }
            $entityManager->persist($club);
            $entityManager->flush();

            return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('club/new.html.twig', [
            'club' => $club,
            'form' => $form,
        ]);
    }

    #[Route('/showClub/{id}', name: 'app_club_show', methods: ['GET'])]
    public function show(Club $club): Response
    {
        return $this->render('club/show.html.twig', [
            'club' => $club,
        ]);
    }

    #[Route('/editClub/{id}', name: 'app_club_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Club $club, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('club/edit.html.twig', [
            'club' => $club,
            'form' => $form,
        ]);
    }

    #[Route('/deleteClub/{id}', name: 'app_club_delete', methods: ['POST'])]
    public function delete(Request $request, Club $club, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $club->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($club);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/user/show', name: 'app_club_show2')]
    public function Show2(ClubRepository $clubRepository): Response
    {
        return $this->render('club/club.html.twig', [
            'clubs' => $clubRepository->findAll(),
        ]);
    }
    #[Route('/club/{id}', name: 'app_club_show_details', methods: ['GET'])]
    public function showDetails(Club $club, EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findBy(['club' => $club]);

        return $this->render('club/show_details.html.twig', [
            'club' => $club,
            'events' => $events,
        ]);
    }

}

#[Route('/club')]
final class UserClubController extends AbstractController 
{
    #[Route('/', name: 'app_club_show2')]
    public function Show(ClubRepository $clubRepository): Response
    {
        return $this->render('club/homeclub.html.twig', [
            'clubs' => $clubRepository->findAll(),
        ]);
    }
}


