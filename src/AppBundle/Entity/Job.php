<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="job")
 */
class Job
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $job_id;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\user",inversedBy="jobs")
     * @ORM\JoinColumn(name="id",referencedColumnName="id")
     */
    private $user;
    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\AskService", cascade={"persist"})
     * @ORM\JoinColumn(name="ask_service_id",referencedColumnName="ask_service_id")
     */
    private $askService;
    /**
     * @return mixed
     */
    public function getJobId()
    {
        return $this->job_id;
    }
    public function getJob_Id()
    {
        return $this->job_id;
    }

    /**
     * @param mixed $job_id
     */
    public function setJobId($job_id)
    {
        $this->job_id = $job_id;
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
     * @return mixed
     */
    public function getAskService()
    {
        return $this->askService;
    }

    /**
     * @param mixed $askService
     */
    public function setAskService($askService)
    {
        $this->askService = $askService;
    }

}