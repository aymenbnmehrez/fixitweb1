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


    public function AddPropositionMobileAction($cnt,$id)
    {
        $cat = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['category_id' => $id]);

        $propo = new Proposition();
        $em = $this->getDoctrine()->getManager();

        $propo->setName($cnt);
        $propo->setCategory($cat);
        $em->persist($propo);
        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted=$serializer->normalize($propo);
        return new JsonResponse($formatted);
    }

    public function favoriserservicemobileAction(Request $request){

        $category=$this->getDoctrine()->getRepository( Service::class)->findAll();
        $list=[];

        $max=0;
        for($i = 0; $i < count($category); ++$i){
            $x=$category[$i]->getNote();

            $max=$max+$x;

        }

        $moy=$max/count($category);

        for($i = 0; $i < count($category); ++$i){
            $Id=$category[$i]->getService_Id();

            $categories=$this->getDoctrine()->getRepository( Service::class)->find($Id);
            if($categories!=null) {

                $nbr = $categories->getNote();

                if (($nbr==5)||($nbr==4)) {
                    array_push($list,$category[$i]);

                }
            }}
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
        $formatted=$serializer->normalize($list);
        return new JsonResponse($formatted);

    }
}