<?php

namespace ClientBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Categoryt;
use AppBundle\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MobileCategorytController extends Controller
{
    public function afficherMobileAction()
    {
        $tab = $this->getDoctrine()->getManager()->getRepository(Categoryt::class)->findAll();
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




    public function ajouterMobileAction(Request $request)
    {   $post = new Categoryt();
        $em = $this->getDoctrine()->getManager();
        $post->setCategoryName($request->get('category_name'));

        $em->persist($post);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($post);
        return new JsonResponse($formatted);
    }
    public function showjsoncategorytAction($id)
    {
        $tab = $this->getDoctrine()->getManager()->getRepository(Categoryt::class)->find($id);
        $encoders = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);

        $formatted=$serializer->normalize($tab);
        return new JsonResponse($formatted);
    }
}
