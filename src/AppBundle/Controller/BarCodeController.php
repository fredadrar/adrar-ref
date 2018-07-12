<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Equipment;
use AppBundle\Form\EquipmentType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BarCodeController extends Controller
{
	public function indexAction()
	{
		return new Response();
	}
	public function addAction(Request $request)
	{
		$equipment = new Equipment();
		
		$barCodeName ="";
		
		$form = $this->get('form.factory')->create(EquipmentType::class, $equipment);
		
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
			
			$category = $equipment->getCategory();
			
			$barCodeName = $category->getName()."_".$category->getCompteur();
			
			$barcode = new \Com\Tecnick\Barcode\Barcode();
			
			// generate a barcode
			try {
				$bobj = $barcode->getBarcodeObj('C128',
												$barCodeName,
												300,
												50,
												'black',
												[10, 10, 10, 10])
								->setBackgroundColor('white');
			}
			catch (Exception $e) {
			}
			
			// output the barcode as HTML div (see other output formats in the documentation and examples)
			$codeBarre = $bobj->getHtmlDiv();
			
			$category->setCompteur($category->getCompteur()+1);
			
			$em = $this->getDoctrine()->getManager();
			$em->flush();
			
			return $this->render('@App/codebarre/index.html.twig', array(
				'barcodename' => $codeBarre
			));
		}
		
		return $this->render('@App/codebarre/add.html.twig', array(
			'form' => $form->createView(),
		));
	}
}