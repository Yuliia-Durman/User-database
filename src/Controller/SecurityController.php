<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

//Klasa: SecurutyController
//Klasa zażądza logowaniem użytkownika

class SecurityController extends AbstractController
{
    // Metoda login
    // sprawdza czy użytkownik istnieje w BD
    // przeprowadza uwierzytelnienie
    // zwraca wyrenderowany widok login.html.twig

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }

        // otrzymaj błąd logowania, jeśli taki istnieje
        $error = $authenticationUtils->getLastAuthenticationError();
        // ostatnia nazwa użytkownika wprowadzona przez użytkownika
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    // Metoda logout
    // wylogowuje użytkownika

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
