<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Equipment;
use AppBundle\Entity\Room;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class WebServiceController extends Controller
{
	/**
	 * @Route("/rooms", name="get-rooms")
	 * @Method("GET")
	 *
	 * @return JsonResponse
	 */
	public function getAllRoomsAction()
	{
		$rooms = $this->getDoctrine()->getRepository(Room::class)->findAll();
		
		$serializer = new Serializer(array(new ObjectNormalizer()));
		$jsonContent = $serializer->serialize($rooms, 'json');
		
//		$jsonData = [];
//		$index = 0;
//		foreach ($rooms as $room) {
//			$temp = [
//				'id' => $room->getId(),
//				'name' => $room->getName(),
//			];
//			$jsonData[$index++] = $temp;
//		}
		
		return new JsonResponse(['data' => json_encode($jsonContent)]);
	}
	
	/**
	 * @Route("/send-equipment", name="send-equipment")
	 * @Method("POST")
	 *
	 * @param Request $request
	 *
	 */
	public function sendEquipmentAndRoom(Request $request)
	{
		$equipmentName = $request->request->get('equipment');
		$roomId = $request->request->get('room');
		
		/** @var Equipment $equipment */
		$equipment = $this->getDoctrine()->getRepository(Equipment::class)->findBy(['name' => $equipmentName]);
		
		if ($equipment) {
			$equipment->setRoom($roomId);
			$this->getDoctrine()->getManager()->flush();
		}
		else {
			$equipment = new Equipment();
			$equipment->setName($equipmentName);
			$equipment-setRoom($roomId);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($equipment);
			$em->flush();
		}
	}
}