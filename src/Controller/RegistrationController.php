<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

//Klasa: RegistrationController
//Klasa zażądza tworzeniem nowego użytkownika

class RegistrationController extends AbstractController
{
    //Metoda: register
    //Metoda:
    //    - tworzy obiekt nowego użytkownika,
    //    - tworzy formularz
    //    - zwraca wyrenderowany widok (register.html.twig) z przekazanym do niego formularzem
    //    - pobiera dane z formularza jeśli został wyslany 
    //    - sprawdza warunki walidacji danych
    //    - przy pozytywnej walidacji zapisuje dane w bazie danych i przykierowuje użytkownika na stronę główną

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // koduje zwykłe hasło
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute("index");
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
