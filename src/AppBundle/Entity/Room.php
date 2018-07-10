<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table(name="room")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoomRepository")
 */
class Room
{
	
	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Equipment", mappedBy="room")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $equipments;
	
	
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;
	
	
	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Room
	 */
	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}
	
	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->equipments = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * Add equipment
	 *
	 * @param \AppBundle\Entity\Equipment $equipment
	 *
	 * @return Room
	 */
	public function addEquipment(\AppBundle\Entity\Equipment $equipment)
	{
		$this->equipments[] = $equipment;
		
		return $this;
	}
	
	/**
	 * Remove equipment
	 *
	 * @param \AppBundle\Entity\Equipment $equipment
	 */
	public function removeEquipment(\AppBundle\Entity\Equipment $equipment)
	{
		$this->equipments->removeElement($equipment);
	}
	
	/**
	 * Get equipments
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getEquipments()
	{
		return $this->equipments;
	}
}
