<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="proposition")
 */
class Proposition
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $proposition_id;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $name;
    /**
     * @ORM\ManyToOne(targetEntity="category",inversedBy="propositions")
     * @ORM\JoinColumn(name="category_id",referencedColumnName="category_id")
     */
    private $category;

    /**
     * @return mixed
     */
    public function getPropositionId()
    {
        return $this->proposition_id;
    }

    /**
     * @param mixed $proposition_id
     */
    public function setPropositionId($proposition_id)
    {
        $this->proposition_id = $proposition_id;
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
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }



}