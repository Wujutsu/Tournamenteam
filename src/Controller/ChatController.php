<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Convertation;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    /**
     * @Route("/ajax/showChatMessages", name="ajax_show_chat_message")
     */
    public function showChatMessages(Request $request): Response
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $convertation = $this->getDoctrine()->getRepository(Convertation::class)->findBy(['contact' => $request->request->get('idChat')]);
            if($convertation){
                $retour = array();
                foreach($convertation as $conv) {
                    $var = new stdClass();
                    $var->pseudo = $conv->getUser()->getPseudo();
                    $var->message = $conv->getMessage();
                    $retour[] = $var;
                }
            } else {
                $retour = false;
            }

            return new JsonResponse($retour);
        } else {
            return $this->redirectToRoute('social');
        }
    }

    /**
     * @Route("/ajax/addChatMessages", name="ajax_add_chat_message")
     */
    public function addChatMessages(Request $request): Response
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $convertation = new Convertation();
            $convertation->setContact($this->getDoctrine()->getRepository(Contact::class)->find($request->request->get('idChat')));
            $convertation->setMessage($request->request->get('message'));
            $convertation->setUser($this->getUser());

            if ($convertation) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($convertation);
                $entityManager->flush();
                $retour = true;
            } else {
                $retour = false;
            }

            return new JsonResponse($retour);
        } else {
            return $this->redirectToRoute('social');
        }
    }
}
