<?php

namespace App\Controller;

use App\Entity\Games;
use App\Entity\Users;
use App\Form\AddGamesFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrationController extends AbstractController
{
    /**
     * @Route("/administration", name="administration")
     */
    public function index(Request $request): Response
    {
        //Form to add new Games
        $games = new Games();
        $form = $this->createForm(AddGamesFormType::class, $games);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $games = $form->getData();
            
            //On enregistre l'image
            $file = $form['name_img']->getData();
            $file->move('images/games', $file->getClientOriginalName());
            $games->setNameImg($file->getClientOriginalName());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($games);
            $entityManager->flush();

            return $this->redirectToRoute('administration');
        }

        //Show all Games
        $showGames = $this->getDoctrine()->getRepository(Games::class)->findAll();

        //Show all Users
        $showUsers = $this->getDoctrine()->getRepository(Users::class)->findAll();

        return $this->render('administration/index.html.twig', [
            'addGamesForm' => $form->createView(),
            'showGames' => $showGames,
            'showUsers' => $showUsers
        ]);
    }

}
