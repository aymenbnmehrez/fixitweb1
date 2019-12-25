<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $post_id;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $title;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $content;
    /**
     * @ORM\Column( type="datetime")
     */
    private $post_date;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\user",inversedBy="posts")
     * @ORM\JoinColumn(name="id",referencedColumnName="id")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }
    public function getPost_Id()
    {
        return $this->post_id;
    }
    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * @ORM\OneToMany(targetEntity="Comments",mappedBy="Post")
     */
    private $commentss;

    /**
     * @return ArrayCollection
     */
    public function getCommentss()
    {
        return $this->commentss;
    }

    /**
     * @param ArrayCollection $commentss
     */
    public function setCommentss($commentss)
    {
        $this->commentss = $commentss;
    }
    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getPostDate()
    {
        return $this->post_date;
    }
    public function getPost_Date()
    {
        return $this->post_date;
    }
    /**
     * @param mixed $post_date
     */
    public function setPostDate($post_date)
    {
        $this->post_date = $post_date;
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
    public function  __construct(){
        $this->commentss=new ArrayCollection();
        $this->post_date = new DateTime();

    }
}