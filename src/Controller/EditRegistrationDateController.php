<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdateDataType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

//Klasa: EditRegistrationDateController
//Klasa zażądzająca edycją danych użytkownika

class EditRegistrationDateController extends AbstractController
{
    //Metoda: index
    //Metoda:
    //    - pobiera dane użytkownika z bazy danych,
    //    - zwraca wyrenderowany widok (edit.html.twig) z przekazanymi do niego danych z bazy danych
    //    - pobiera aktualne dane z widoku
    //    - aktualizuje dane w bazie danych
    
    /**
     * @Route("/edit/database/{id}", name="edit_database")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
     public function index(Request $request, int $id): Response
    {     
        $em = $this->getDoctrine()->getManager();
        //wybieramy z bazy danych dane o odpowiednim id
        $this->user = $user = $this->userData = $em->getRepository(User::class)->find($id);
        $this->form = $form = $this->createForm(UpdateDataType::class, $user);
        
        try { 
            $form->handleRequest($request);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Nie udało się aktualizować dane użytkownika.');
            return $this->redirectToRoute("index");
        }

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $user = $form->getData();
            //Powiadomienie Doctrine, że chcemy zapisać użytkownika
            $em->persist($user); 
            // Faktyczne wykonywanie zapytania (INSERT)           
            $em->flush();
            return $this->redirectToRoute("index");
        }
                       
        return $this->render('edit/edit.html.twig', [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'password' => $user->getPassword(),
            'surname' => $user->getSurname(),
            'number' => $user->getNumber(),
            'email' => $user->getEmail(),
            'type' => $user->getTypeUser(),
            'form' => $form->createView()
            
        ]);
    }
}
   

