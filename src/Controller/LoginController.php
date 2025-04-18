<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
        SessionInterface $session
    ): Response {
        $error = null;

        // If user is already logged in, redirect them based on role
        if ($session->get('user_id')) {
            return $this->redirectBasedOnRole($session->get('user_role'));
        }

        // Create the login form
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data['email'];
            $password = $data['password'];

            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user && $hasher->isPasswordValid($user, $password)) {
                // Store user info in session
                $session->set('user_id', $user->getId());
                $session->set('user_email', $user->getEmail());
                $session->set('user_role', $user->getRole());

                // Redirect based on role
                return $this->redirectBasedOnRole($user->getRole());
            } else {
                $error = 'Invalid email or password.';
            }
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    private function redirectBasedOnRole(string $role): Response
    {
        switch ($role) {
            case 'Admin':
                return $this->redirectToRoute('app_dashboard');
            case 'Student':
            default:
                return $this->redirectToRoute('app_home');
        }
    }
    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): Response
    {
        // Clear all session data
        $session->clear();

        // Redirect to login page
        return $this->redirectToRoute('app_login');
    }
}
