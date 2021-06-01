<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Users;
use App\Form\AddFriendFormType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocialController extends AbstractController
{
    /**
     * @Route("/social", name="social")
     */
    public function index(Request $request, ContactRepository $contactRepository): Response
    {
        //Show friend of user
        $friendList = $contactRepository->findAllFriendOfUser($this->getUser()->getId());

        //Form to add a friend
        $contact = new Contact();
        $formAddFriend = $this->createForm(AddFriendFormType::class, $contact);
        $formAddFriend->handleRequest($request);
        if($formAddFriend->isSubmitted() && $formAddFriend->isValid()) {
            $contact = $formAddFriend->getData();
            $idOfPseudo = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['Pseudo' => $request->request->get('pseudo')]);

            if(!empty($idOfPseudo)) {
                $contact->setUser($this->getUser());
                $contact->setContact($idOfPseudo);
                $contact->setAccept(0);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($contact);
                $entityManager->flush();

                $contactBis = new Contact();
                $contactBis->setUser($idOfPseudo);
                $contactBis->setContact($this->getUser());
                $contactBis->setAccept(1);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($contactBis);
                $entityManager->flush();
            }

            return $this->redirectToRoute('social');
        }

        return $this->render('social/index.html.twig', [
            'addFriendForm' => $formAddFriend->createView(),
            'friendList' => $friendList
        ]);
    }

    /**
     * @Route("/ajax/verificationPseudo", "ajax_verification_pseudo")
     */
    public function verificationPseudo(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $verifPseudo = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['Pseudo' => $request->request->get('pseudo')]);
            if($verifPseudo){
                $verifDoublon = $this->getDoctrine()->getRepository(Contact::class)->findOneBy(['user' => $this->getUser()->getId(), 'contact' => $verifPseudo->getId()]);
                ($verifDoublon) ? $retour = 'Déjà en ami' : $retour = true;
            } else {
                $retour = 'Pseudo inconnu';
            } 

            return new JsonResponse($retour);
        } else {
            return $this->redirectToRoute('social');
        }
    }

    /**
     * @Route("/ajax/acceptFriend", "ajax_accept_friend")
     */
    public function acceptFriend(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $entityManager = $this->getDoctrine()->getManager();
            $contact = $entityManager->getRepository(Contact::class)->findOneBy(['user' => $this->getUser(), 'contact' => $request->request->get('id')]);
            $contactBis = $entityManager->getRepository(Contact::class)->findOneBy(['user' => $request->request->get('id'), 'contact' => $this->getUser()]);
            
            $retour = false;
            if ($contact && $contactBis) {
                $contact->setAccept(2);
                $entityManager->flush();
                $contactBis->setAccept(2);
                $entityManager->flush();
                $retour = true;
            }

            return new JsonResponse($retour);
        } else {
            return $this->redirectToRoute('social');
        }
    }

    /**
     * @Route("/ajax/deleteFriend", "ajax_delete_friend")
     */
    public function deleteFriend(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $entityManager = $this->getDoctrine()->getManager();
            $contact = $entityManager->getRepository(Contact::class)->findOneBy(['user' => $this->getUser(), 'contact' => $request->request->get('id')]);
            $contactBis = $entityManager->getRepository(Contact::class)->findOneBy(['user' => $request->request->get('id'), 'contact' => $this->getUser()]);
            
            $retour = false;
            if ($contact && $contactBis) {
                $entityManager->remove($contact);
                $entityManager->flush();
                $entityManager->remove($contactBis);
                $entityManager->flush();
                $retour = true;
            }

            return new JsonResponse($retour);
        } else {
            return $this->redirectToRoute('social');
        }
    }
}
