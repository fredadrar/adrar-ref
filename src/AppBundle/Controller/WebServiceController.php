<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Equipment;
use AppBundle\Entity\Room;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class WebServiceController extends Controller
{
	/**
	 * @Route("/rooms", name="get-rooms")
	 * @Method("GET")
	 *
	 * @param SerializerInterface $serializer
	 *
	 * @return string
	 */
	public function getAllRoomsAction(SerializerInterface $serializer)
	{
		$rooms = $this->getDoctrine()->getRepository(Room::class)->findAll();

		$jsonContent = $serializer->serialize($rooms, 'json', [
			'groups' => ['room'],
		]);

		return new JsonResponse($jsonContent, 200, array(), true);
	}
	
	/**
	 * @Route("/send-equipment", name="send-equipment")
	 * @Method("POST")
	 *
	 * @param Request $request
	 *
	 * @return Response
	 * @throws \Exception
	 */
	public function sendEquipmentAndRoom(Request $request)
	{
		$categoryName = null;
		
		$jsonReceived = json_decode($request->getContent(), true);
		
		$name = $jsonReceived['equipment'];
		$room = $this->getDoctrine()->getRepository(Room::class)->findOneBy( ['name' => $jsonReceived['room']] );
		
		//On extrait la catégorie du nom du matériel :
		preg_match('~.+(?=_)~', $name, $out);
		if ($out) {
			$categoryName = $out[0];
		}
		$category = $this->getDoctrine()->getRepository(Category::class)->findOneBy( ['name' => $categoryName] );
		
		if (!$name || !$room || !$category) {
			return new Response('pas bon');
		}
		
		else {
			$equipment = $this->getDoctrine()->getRepository(Equipment::class)->findOneBy( ['name' => $name] );
			$em = $this->getDoctrine()->getManager();
			
			if ($equipment) {
				$equipment->setRoom($room);
				$em->flush();
			}
			else {
				$equipment = new Equipment();
				$equipment->setName($name)
						  ->setRoom($room)
						  ->setCategory($category);
				$em->persist($equipment);
				$em->flush();
			}
			return new Response('ok cool');
		}
	}
}