<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**

 * @ORM\Table(name="adfav")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdFavRepository")
 */
class AdFav
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $adFav_id;


    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User",inversedBy="ads")
     * @ORM\JoinColumn(name="idUser",referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ad",inversedBy="ads")
     * @ORM\JoinColumn(name="idAd",referencedColumnName="ad_id")
     */
    private $idAd;

    /**
     * @return mixed
     */
    public function getAdFavId()
    {
        return $this->adFav_id;
    }

    /**
     * @param mixed $adFav_id
     */
    public function setAdFavId($adFav_id)
    {
        $this->adFav_id = $adFav_id;
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
    public function getIdAd()
    {
        return $this->idAd;
    }

    /**
     * @param mixed $idAd
     */
    public function setIdAd($idAd)
    {
        $this->idAd = $idAd;
    }

   }
