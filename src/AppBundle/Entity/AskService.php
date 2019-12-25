<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="ask_service")
 */
class AskService
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $ask_service_id;
    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $date;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $duration;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $description;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $service_name;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $started_at;

    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return $this->service_name;
    }
    public function getService_Name()
    {
        return $this->service_name;
    }
    /**
     * @param mixed $service_name
     */
    public function setServiceName($service_name)
    {
        $this->service_name = $service_name;
    }
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $status= 'Not Confirmed';
    /**
     * @ORM\Column(type="integer")
     */
    private $price;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\user",inversedBy="ask_services")
     * @ORM\JoinColumn(name="id",referencedColumnName="id")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getAskServiceId()
    {
        return $this->ask_service_id;
    }
    public function getAsk_Service_Id()
    {
        return $this->ask_service_id;
    }
    /**
     * @param mixed $ask_service_id
     */
    public function setAskServiceId($ask_service_id)
    {
        $this->ask_service_id = $ask_service_id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getStartedAt()
    {
        return $this->started_at;
    }
    public function getStarted_At()
    {
        return $this->started_at;
    }
    /**
     * @param mixed $started_at
     */
    public function setStartedAt($started_at)
    {
        $this->started_at = $started_at;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
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

}