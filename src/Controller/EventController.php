<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\AddEventsFormType;
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
        return $this->redirectToRoute("event");
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
        $showEventGame = $eventRepository->findAllEventGame();

        return $this->render('event/index.html.twig', [
            'addEventForm' => $form->createView(),
            'showEventGame' => $showEventGame
        ]);
    }

    /**
     * @Route("/evenement/affiche", name="event_select")
     */
    public function eventSelect()
    {
        return $this->render('event/showSelectEvent.html.twig', [

        ]);
    }

}
