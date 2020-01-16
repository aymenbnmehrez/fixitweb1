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




//    public function ajouterMobileAction( $idUser,$title,$content)
//    {
//       // $idPosts = $this->getDoctrine()->getRepository(Categoryt::class)->findOneBy(['id' => $id]);
//      //  $idUsers = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $idUser]);
//        $post = new Post();
//        $post->setTitle($title);
//        $post->setContent($content);
//        //$post->setContent($request->get('id'));
//       // $post->setUser($idUsers);
//        $em = $this->getDoctrine()->getManager();
//
//        $em->persist($post);
//        $em->flush();
//        $serializer=new Serializer([new ObjectNormalizer()]);
//        $formatted=$serializer->normalize($post);
//        return new JsonResponse($formatted);
//    }

    public function deletePostMobileAction($id){
        $em = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $em->remove($post);
        $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted=$serializer->normalize($post);
        return new JsonResponse($formatted);
    }


    public function ajouterpOSTMobileAction( $idUser,$title,$content)
    {


        $idUsers = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $idUser]);

        $comment = new Post();
        $em = $this->getDoctrine()->getManager();


        $comment->setTitle($title);
        $comment->setContent($content);
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


}