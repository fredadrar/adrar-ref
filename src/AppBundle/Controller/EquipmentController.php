<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EquipmentController extends Controller
{
    public function indexAction()
    {
        $listEquipments = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Equipment')
            ->getAllEquipments();
        ;

        // On donne toutes les informations nécessaires à la vue
        return $this->render('@App/Equipment/index.html.twig', array(
            'listequipments'        => $listEquipments,
        ));
    }
    
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $equipment = $em->getRepository('AppBundle:Equipment')->find($id);

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($equipment);
            $em->flush();
            
            return $this->redirectToRoute('equipment_home');
        }

        return $this->render('@App/Equipment/delete.html.twig', array(
            'equipment' => $equipment,
            'form'   => $form->createView(),
        ));
    }
}