<?php

namespace ClientBundle\Controller;
use AppBundle\Entity\Comments;
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




class CommentmobileController extends Controller
{
   public function affichercomMobileAction($id)
   {
       //$tab = $this->getDoctrine()->getManager()->getRepository(Comments::class)->findAll();

       $taab = $this->getDoctrine()->getManager()->getRepository(Comments::class);
       $tab=$taab->findBy(['idPost'=>$id]);




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




    public function ajoutercomMobileAction($cnt,$id)
    {


        $idPosts = $this->getDoctrine()->getRepository(Post::class)->findOneBy(['post_id' => $id]);

        $comment = new Comments();
        $em = $this->getDoctrine()->getManager();


        $comment->setComment($cnt);
        $comment->setIdPost($idPosts);

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
}