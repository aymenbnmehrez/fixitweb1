<?php
namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comments
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     *@ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $comment;




    /**
     * @ORM\Column( type="datetime")
     */
    private $dateComment;

    /**
     * @ORM\ManyToOne(targetEntity="Post",inversedBy="commentss")
     * @ORM\JoinColumn(name="post_id",referencedColumnName="post_id")
     */
    private $idPost;


    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\user",inversedBy="commentsss")
     * @ORM\JoinColumn(name="idd",referencedColumnName="id")
     */
    private $user;

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
    public function getIdUser()
    {
        return $this->idUser;
    }



    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getIdPost()
    {
        return $this->idPost;
    }

    /**
     * @param mixed $idPost
     */
    public function setIdPost($idPost)
    {
        $this->idPost = $idPost;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return DateTime
     */
    public function getDateComment()
    {
        return $this->dateComment;
    }


    /**
     * @param DateTime $dateComment
     */
    public function setDateComment($dateComment)
    {
        $this->dateComment = $dateComment;
    }



    public function  __construct(){
        $this->dateComment = new DateTime();

    }


}


