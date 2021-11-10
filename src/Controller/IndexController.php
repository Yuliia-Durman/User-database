<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

//Klasa: IndexController
//Klasa zażądza wyświetłeniem danych użytkowników

class IndexController extends AbstractController
{
    //Metoda: index
    //Metoda:
    //    - pobiera dane wszystkich użytkowników z bazy danych,
    //    - zwraca wyrenderowany widok (index.html.twig) z przekazanymi do niego danych z bazy danych

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getRepository(User::class)->findAll();
        

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'latestUsers' => $em
        ]);
    }
}
