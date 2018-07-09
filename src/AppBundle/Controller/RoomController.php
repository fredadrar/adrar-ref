<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 09/07/2018
 * Time: 14:24
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Room;
use AppBundle\Form\RoomType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RoomController extends Controller
{
    public function indexAction()
    {
        $listRoom = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Room')
            ->getAllRooms();
        ;

        // On donne toutes les informations nécessaires à la vue
        return $this->render('@App/Room/index.html.twig', array(
            'listroom'        => $listRoom,
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


        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($room);
            $em->flush();


            return $this->redirectToRoute('room_home');
        }

        return $this->render('@App/Room/delete.html.twig', array(
            'room' => $room,
            'form'   => $form->createView(),
        ));
    }
}