<?php

namespace ClientBundle\Controller;

use AppBundle\Entity\Categoryt;
use AppBundle\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;

class MobileTicketController extends Controller
{
    public function afficherMobileAction()
    {
        $tab = $this->getDoctrine()->getManager()->getRepository(Ticket::class)->findAll();
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
    {   $post = new Ticket();
        $em = $this->getDoctrine()->getManager();
        $post->setStatus($request->get('status'));
        $post->setDescription($request->get('description'));
        $post->setDateTicket($request->get('date_ticket'));
        $post->setImage($request->get('image'));
      // $post->setStatus($request->get('category_name'));
        //$post->setStatus($request->get('category_name'));
        $em->persist($post);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($post);
        return new JsonResponse($formatted);
    }
    public function showjsonticketAction($id)
    {
        $tab = $this->getDoctrine()->getManager()->getRepository(Ticket::class)->find($id);
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
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $ticket = $em->getRepository(Ticket::class)->find($id);
        $em->remove($ticket);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ticket);
        return new JsonResponse($formatted);

    }
    public function afficherCateMobileAction($id)
    {
        //$tab = $this->getDoctrine()->getManager()->getRepository(Comments::class)->findAll();
        $em = $this->getDoctrine()->getManager();
        $askService=$em->getRepository(Categoryt::class)->find($id);


        $taab = $this->getDoctrine()->getManager()->getRepository(Ticket::class);
        $tab=$taab->findBy(['categoryt'=>$askService]);




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

    public function afficherTicketMobileAction($id)
    {
        //$tab = $this->getDoctrine()->getManager()->getRepository(Comments::class)->findAll();

        $taab = $this->getDoctrine()->getManager()->getRepository(Ticket::class);
        $tab=$taab->findBy(['categoryt'=>$id]);




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

    public function ajouterTicketMobileAction($cnt,$id,$idUser)
    {


        $idPosts = $this->getDoctrine()->getRepository(Categoryt::class)->findOneBy(['id' => $id]);
        $idUsers = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $idUser]);

        $comment = new Ticket();
        $em = $this->getDoctrine()->getManager();


        $comment->setDescription($cnt);
        $comment->setCategoryt($idPosts);
        $comment->setUser($idUsers);
        $em->persist($comment);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted=$serializer->normalize($comment);
        return new JsonResponse($formatted);
    }

    public function afficherCateNameMobileAction($id)
    {
        //$tab = $this->getDoctrine()->getManager()->getRepository(Comments::class)->findAll();
//        $em = $this->getDoctrine()->getManager();
//        $askService=$em->getRepository(Categoryt::class)->findBy(['categoryName'=>$id]);

        $tab = $this->getDoctrine()->getManager()->getRepository(Categoryt::class)->findOneBy(['categoryName'=>$id]);


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

}
