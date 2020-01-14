<?php

namespace ClientBundle\Controller;
use AppBundle\Entity\Category;
use AppBundle\Entity\Proposition;
use AppBundle\Entity\Service;
use AppBundle\Form\PropositionType;
use AppBundle\Form\PropType;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;





class CategorymobileController extends Controller
{
   public function afficherMobileCatAction()
   {
       $tab = $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll();
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
    public function afficheServiceMobileAction($id)
    {
        //$cat=$this->getDoctrine()->getRepository(Category::class)->findOneBy(['category_id'=>$id]);

        $Service=$this->getDoctrine()->getRepository(Service::class)->findBy(array('category'=>$id));
        $encoders = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
//    $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($Service);
        return new JsonResponse($formatted);

    }



//    public function ajouterMobileAction(Request $request)
//    {   $post = new Post();
//        $em = $this->getDoctrine()->getManager();
//        $post->setTitle($request->get('title'));
//        $post->setContent($request->get('content'));
//        $em->persist($post);
//        $em->flush();
//        $serializer=new Serializer([new ObjectNormalizer()]);
//        $formatted=$serializer->normalize($post);
//        return new JsonResponse($formatted);
//    }


        public function AddPropositionMobileAction(Request $request)
    {

        $propo = new Proposition();
        $em = $this->getDoctrine()->getManager();
        $category = $this->getDoctrine()->getManager()->getRepository(Category::class)->find($request->get('category'));
     //   $idAd = $this->getDoctrine()->getManager()->getRepository(Ad::class)->find($request->get('idAd'));

        $propo->setName($request->get('name'));
        $propo->setCategory($category);

        $em->persist($propo);
        $em->flush();

          $serializer=new Serializer([new ObjectNormalizer()]);
          $formatted=$serializer->normalize($propo);
          return new JsonResponse($formatted);








    }



//    public function favoriteAction(Request $request){
//        $adFav = new AdFav();
//        $em = $this->getDoctrine()->getManager();
//        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($request->get('user'));
//        $idAd = $this->getDoctrine()->getManager()->getRepository(Ad::class)->find($request->get('idAd'));
//
//        $adFav->setUser($user);
//        $adFav->setIdAd($idAd);
//
//        $em->persist($adFav);
//        $em->flush();
//
//        $encoder = array(new XmlEncoder(), new JsonEncoder());
//        $normalizer = new ObjectNormalizer();
//        $normalizer->setCircularReferenceLimit(2);
//        $normalizer->setCircularReferenceHandler(function ($object) {return $object;});
//        $normalizers = array($normalizer);
//        $serializer = new Serializer($normalizers, $encoder);
//        $formatted=$serializer->normalize($adFav);
//        return new JsonResponse($formatted);
//
//
//
//    }

}