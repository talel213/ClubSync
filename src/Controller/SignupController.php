<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignupType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class SignupController extends AbstractController
{
    #[Route('/signup', name: 'app_signup')]
    public function Signup(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $em): Response
    {

        $user = new User();
        $form = $this->createForm(SignupType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Set admin role if email matches
            if ($user->getEmail() === 'talelbengharbia213@gmail.com') {
                $user->setRole('Admin');
            }

            $user->setPassword(
                $hasher->hashPassword(
                    $user, // Pass the User entity itself
                    $form->get('plainPassword')->getData() // Make sure this matches your form field name
                )
            );

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }
        return $this->render('signup/index.html.twig', [
            'form' => $form,
        ]);
    }
}
