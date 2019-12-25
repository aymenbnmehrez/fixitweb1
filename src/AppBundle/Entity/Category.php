<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $category_id;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $name;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $description;
    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    private $image;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Service",mappedBy="category",cascade={"persist","remove"})
     */
    private $services;

    /**
     * @return ArrayCollection
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param ArrayCollection $services
     */
    public function setServices($services)
    {
        $this->services = $services;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
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
     * @param mixed $image
*/
    public function setImage($image)
    {
        $this->image = $image;
    }

    public function __construct()
    {
        $this->services = new ArrayCollection();  // your own logic

        // your own logic
    }



}