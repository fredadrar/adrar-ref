<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Equipment;
use AppBundle\Entity\Room;
use AppBundle\Form\RoomType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RoomController extends Controller
{
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		$listRooms = $em->getRepository('AppBundle:Room')->findAll();

        // On donne toutes les informations nécessaires à la vue
        return $this->render('@App/Room/index.html.twig', array(
            'listrooms'        => $listRooms,
        ));
    }
    
    public function addAction(Request $request)
    {
        $room = new Room();

        $form = $this->get('form.factory')->create(RoomType::class, $room);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
        	
            $em = $this->getDoctrine()->getManager();
            $em->persist($room);
            $em->flush();
            
            return $this->redirectToRoute('room_home');
        }

        return $this->render('@App/Room/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $room = $em->getRepository('AppBundle:Room')->find($id);
        $reserve = $em->getRepository('AppBundle:Room')->findOneBy(['name' => 'Réserve']);
        
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        	
        	$equipments = $em->getRepository(Equipment::class)->findBy(['room' => $room]);
        	foreach ($equipments as $equipment) {
        		$equipment->setRoom($reserve);
			}
            $em->remove($room);
            $em->flush();
            
            return $this->redirectToRoute('room_home');
        }

        return $this->render('@App/Room/delete.html.twig', array(
            'room' => $room,
            'form' => $form->createView(),
        ));
    }
}