<?php

namespace ClientBundle\Controller;

use AppBundle\Entity\Ad;
use AppBundle\Entity\AdFav;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;


class MobileAdsController extends Controller
{
    public function displayMobileAdsAction()
    {
        $tab = $this->getDoctrine()->getManager()->getRepository(Ad::class)->findAll();
        $encoder = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {return $object;});
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoder);
//      $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($tab);
        return new JsonResponse($formatted);
    }

    public function favoriteAction(Request $request){
        $adFav = new AdFav();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($request->get('user'));
        $idAd = $this->getDoctrine()->getManager()->getRepository(Ad::class)->find($request->get('idAd'));

            $adFav->setUser($user);
            $adFav->setIdAd($idAd);

            $em->persist($adFav);
            $em->flush();

        $encoder = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {return $object;});
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoder);
        $formatted=$serializer->normalize($adFav);
        return new JsonResponse($formatted);



    }

    public function showFavoriteAction($idUser){
        //$user = $this->container->get('security.token_storage')->getToken()->getUser();
        $adFav=$this->getDoctrine()->getRepository(AdFav::class)->findBy(['user' => $idUser]);
        $encoder = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {return $object;});
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoder);
//      $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($adFav);
        return new JsonResponse($formatted);

    }

}