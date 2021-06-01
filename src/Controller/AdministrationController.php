<?php

namespace App\Controller;

use App\Entity\Games;
use App\Entity\Users;
use App\Form\AddGamesFormType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrationController extends AbstractController
{
    /**
     * @Route("/administration", name="administration")
     */
    public function index(Request $request, ContactRepository $contactRepository): Response
    {
        //Form to add new Games
        $games = new Games();
        $form = $this->createForm(AddGamesFormType::class, $games);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $games = $form->getData();
            
            //Save picture
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

        //Show friend of user
        $friendListOne = $contactRepository->findAllFriendOfUser($this->getUser()->getId());
        $friendListTwo = $contactRepository->findAllUserOfFriend($this->getUser()->getId());

        return $this->render('administration/index.html.twig', [
            'addGamesForm' => $form->createView(),
            'showGames' => $showGames,
            'showUsers' => $showUsers,
            'friendListOne' => $friendListOne,
            'friendListTwo' => $friendListTwo,
        ]);
    }

    /**
     * @Route("/ajax/deleteGame", name="ajax_delete_game")
     */
    public function deleteGame(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $return = false;
            $entityManager = $this->getDoctrine()->getManager();
            $games = $entityManager->getRepository(Games::class)->find($request->request->get('id'));
            
            if ($games) {
                $fileSystem = new Filesystem();
                $fileSystem->remove('images/games/'.$games->getNameImg());
                $entityManager->remove($games);
                $entityManager->flush();
                $return = true;
            }

            return new JsonResponse($return);
        } else {
            return $this->redirectToRoute('event');
        }
    }

}
