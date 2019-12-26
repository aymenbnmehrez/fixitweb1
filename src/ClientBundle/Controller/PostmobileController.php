<?php

namespace ClientBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;




class PostmobileController extends Controller
{
   public function afficherMobileAction()
   {
       $tab = $this->getDoctrine()->getManager()->getRepository(Post::class)->findAll();
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
    {   $post = new Post();
        $em = $this->getDoctrine()->getManager();
        $post->setTitle($request->get('title'));
        $post->setContent($request->get('content'));
        $em->persist($post);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($post);
        return new JsonResponse($formatted);
    }
}