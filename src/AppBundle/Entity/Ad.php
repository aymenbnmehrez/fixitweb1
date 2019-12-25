<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="ad")
 */
class Ad
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $ad_id;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $name;
    /**
     * @ORM\Column(type="date")
     */
    private $availability;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $description;
    /**
     * @ORM\Column(type="datetime")
     */
    private $published_at;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\user",inversedBy="ads")
     * @ORM\JoinColumn(name="id",referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AdFav", mappedBy="idAd",cascade={"persist","remove"})
     */
    private $likes;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $location;

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAdId()
    {
        return $this->ad_id;
    }

    /**
     * @param mixed $ad_id
     */
    public function setAdId($ad_id)
    {
        $this->ad_id = $ad_id;
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
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param mixed $availability
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;
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
    public function getPublishedAt()
    {
        return $this->published_at;
    }

    /**
     * @param mixed $published_at
     */
    public function setPublishedAt($published_at)
    {
        $this->published_at = $published_at;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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
     * Add like
     *
     * @param \AppBundle\Entity\AdFav $like
     *
     * @return Ad
     */
    public function addLike(\AppBundle\Entity\AdFav $like)
    {
        $this->likes[] = $like;

        return $this;
    }

    /**
     * Remove like
     *
     * @param \AppBundle\Entity\AdFav $like
     */
    public function removeLike(\AppBundle\Entity\AdFav $like)
    {
        $this->likes->removeElement($like);
    }

    /**
     * Get likes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikes()
    {
        return $this->likes;
    }
}
