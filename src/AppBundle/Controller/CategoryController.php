<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();

        return $this->render('@App/category/index.html.twig', array(
            'categories' => $categories,
        ));
    }
    
    public function newAction(Request $request)
    {
        $category = new Category();
        $category->setCompteur(1);
        $form = $this->createForm('AppBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_home', array('id' => $category->getId()));
        }

        return $this->render('@App/category/new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }
    
    public function editAction(Request $request, Category $category)
    {
        $editForm = $this->createForm('AppBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_home', array('id' => $category->getId()));
        }

        return $this->render('@App/category/edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
        ));
    }
	
	public function deleteAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		
		$category = $em->getRepository('AppBundle:Category')->find($id);
		
		$form = $this->get('form.factory')->create();
		
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em->remove($category);
			$em->flush();
			
			return $this->redirectToRoute('category_home');
		}
		
		return $this->render('@App/category/delete.html.twig', array(
			'category' => $category,
			'form'   => $form->createView(),
		));
	}
}
