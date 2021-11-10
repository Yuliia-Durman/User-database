<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

//Klasa: RemoveDatabaseController
//Klasa zażądza usuwaniem użytkownika z bazy danych

class RemoveDatabaseController extends AbstractController
{
    //Metoda: index
    //      dziedziczy metode index() po klasie AbstractController

    /**
     * @Route("/remove", name="remove")
     */
    public function index()
    {

    }

    //Metoda: remove
    //Metoda:
    //    - pobiera obiekty z bazy danych
    //    - usuwa wybrane obiekty z bazy danych
    //    - przekierowuje na stronę główną

    /**
     * @Route("/remove/database/{id}", name="remove_database")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    
    public function remove(int $id)
    {
        //pobieranie obiektu z Doctrine
        $em = $this->getDoctrine()->getManager();
        $dataUser = $em->getRepository(User::class)->find($id);

        $em->remove($dataUser);
        $em->flush();
        $this->addFlash('success', 'Usunięto dane użytkownika.');

        return $this->redirectToRoute('index');
    }
}