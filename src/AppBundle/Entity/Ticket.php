<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity
 */
class Ticket
{
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User",inversedBy="tickets_user")
     * @ORM\JoinColumn(name="idUser",referencedColumnName="id")
     */
    private $user;
    /**
     * @var string
     *
     * @ORM\Column(name="provider", type="string", length=255, nullable=true)
     */
    private $provider;

    /**
     * @ORM\ManyToOne(targetEntity="Categoryt",inversedBy="tickets")
     * @ORM\JoinColumn(name="idC",referencedColumnName="id")
     */
    private $categoryt;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTicket", type="datetime",nullable=true)
     */
    private $dateTicket;
    /**
     * @ORM\Column(type="string",nullable=false)
     */
    private $status= 'Not Treated';
    /**
     * @return mixed
     */
    public function getStatus()
    {

        return $this->status;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Ticket constructor.
     * @param \DateTime $dateTicket
     */
    public function __construct()
    {
        $this->dateTicket = new DateTime();

    }

    /**
     * @return mixed
     */
    public function getCategoryt()
    {
        return $this->categoryt;
    }

    /**
     * @param mixed $categoryt
     */
    public function setCategoryt($categoryt)
    {
        $this->categoryt = $categoryt;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", nullable=true)
     */
    private $image;


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
     * Set decription
     *
     * @param string $decription
     *
     * @return Ticket
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get decription
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



    /**
     * Set provider
     *
     * @param string $provider
     *
     * @return Ticket
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set idC
     *
     * @param integer $idC
     *
     * @return Ticket
     */
    public function setIdC($idC)
    {
        $this->idC = $idC;

        return $this;
    }

    /**
     * Get idC
     *
     * @return int
     */
    public function getIdC()
    {
        return $this->idC;
    }

    /**
     * Set dateTicket
     *
     * @param \DateTime $dateTicket
     *
     * @return Ticket
     */
    public function setDateTicket($dateTicket)
    {
        $this->dateTicket = new \DateTime('now');

        return $this;
    }

    /**
     * Get dateTicket
     *
     * @return \DateTime
     */
    public function getDateTicket()
    {
        //return new \DateTime();
        return $this->dateTicket;

    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Ticket
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

}

