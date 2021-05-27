<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Event;
use App\Form\AddCommentFormType;
use App\Form\AddEventsFormType;
use App\Repository\CommentRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{

    /**
     * @Route("/", name="redirect_event")
     */
    public function redict_event()
    {
        return $this->redirectToRoute('event');
    }

    /**
     * @Route("/evenement", name="event")
     */
    public function index(Request $request, EventRepository $eventRepository): Response
    {
        //Form to add Event
        $event = new Event();
        $form = $this->createForm(AddEventsFormType::class, $event);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            
            $event->setuser($this->getUser());
            $event->setCreatedAt(new \DateTime("now"));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event');
        }

        //Show all Event Game
        $showAllEventGame = $eventRepository->findAllEventGame();

        return $this->render('event/index.html.twig', [
            'addEventForm' => $form->createView(),
            'showAllEventGame' => $showAllEventGame
        ]);
    }

    /**
     * @Route("/evenement/affiche", name="redirect_event_select")
     */
    public function redict_event_select()
    {
        return $this->redirectToRoute('event');
    }

    /**
     * @Route("/evenement/affiche/{id}", name="event_select")
     */
    public function eventSelect(Request $request, EventRepository $eventRepository, CommentRepository $commentRepository)
    {
        //Show Event Game
        $showEventGame = $eventRepository->findEventGame($request->attributes->get('id'));
        if(sizeof($showEventGame) == 0)
            return $this->redirectToRoute('event');
        else   
            $idEvent = $request->attributes->get('id');

        //Show all comments of event
        $showAllCommentsEvent = $commentRepository->findAllCommentOfEvent($idEvent);

        //Form to add commentary
        $comment = new Comment();
        $form = $this->createForm(AddCommentFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            
            $comment->setUsers($this->getUser());
            $comment->setEvent($this->getDoctrine()->getRepository(Event::class)->find($idEvent));
            $comment->setCreatedAt(new \DateTime("now"));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('event_select', ['id' => $idEvent]);
        }

        return $this->render('event/showSelectEvent.html.twig', [
            'showEventGame' => $showEventGame,
            'showAllCommentsEvent' => $showAllCommentsEvent,
            'addCommentForm' => $form->createView()
        ]);
    }

}
