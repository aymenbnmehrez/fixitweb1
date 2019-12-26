<?php

namespace ProviderBundle\Controller;

use AppBundle\Entity\Ad;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class MobileAdsController extends Controller
{
    public function displayMobileAdsAction()
    {
        $tabad = $this->getDoctrine()->getManager()->getRepository(Ad::class)->findAll();
        $encoder = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoder);
//    $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($tabad);
        return new JsonResponse($formatted);
    }

}