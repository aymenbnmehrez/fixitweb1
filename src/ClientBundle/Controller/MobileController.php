<?php

namespace ClientBundle\Controller;

use AppBundle\Entity\AskService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;


class MobileController extends Controller
{
    public function displayMobileAction()
    {
    $tab = $this->getDoctrine()->getManager()->getRepository(AskService::class)->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
//    $serializer=new Serializer([new ObjectNormalizer()]);
    $formatted=$serializer->normalize($tab);
    return new JsonResponse($formatted);
}
    public function addAskServiceAction(Request $request)
    {   $askService = new AskService();
        $em = $this->getDoctrine()->getManager();
        $askService->setDescription($request->get('description'));
        $askService->setPrice(11);
        $askService->setDuration('123');
        $askService->setServiceName('dvvf');
        $askService->setStartedAt($request->get('startedAt'));
        $em->persist($askService);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($askService);
        return new JsonResponse($formatted);
    }
}
