<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 09/07/2018
 * Time: 16:00
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Equipment;
use AppBundle\Form\EquipmentType;
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

    public function addAction(Request $request)
    {

        $equipment = new Equipment();

        $barCodeName ="";

        $form = $this->get('form.factory')->create(EquipmentType::class, $equipment);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){

            dump($equipment);

            $category = $equipment->getCategory();

            $barCodeName = $category->getName()."_".$category->getCompteur();

            $category->setCompteur($category->getCompteur()+1);

            $em = $this->getDoctrine()->getManager();
            $em->flush();


           return $this->redirectToRoute('code_home', array(
                'barcodename' => $barCodeName
            ));


        }



        return $this->render('@App/Equipment/add.html.twig', array(
            'form' => $form->createView(),
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