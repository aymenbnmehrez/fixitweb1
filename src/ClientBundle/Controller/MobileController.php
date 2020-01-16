<?php

namespace ClientBundle\Controller;

use AppBundle\Entity\AskService;
use AppBundle\Entity\Job;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use \UserBundle\Entity\User;


class MobileController extends Controller
{
    public function displayMobileAction($idUser)
    {
    $tab = $this->getDoctrine()->getManager()->getRepository(AskService::class)->findBy(['user' => $idUser]);
        $encoders = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
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
//auth
    public function loginAction($username,$password)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');
        $user = $user_manager->findUserByUsername($username);
        $encoders = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $encoder = $factory->getEncoder($user);
        $users = $this->getDoctrine()->getRepository(User::class)->findBy(array('username'=>$username));
        $bool = ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) ? "true" : "false";
        if($bool == "true" )
        {
            $serializer = new Serializer($normalizers, $encoders);
            $formatted = $serializer->normalize($users);
            return new JsonResponse($formatted);
        }
        else
        {
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize(false);
            return new JsonResponse($formatted);
        }
    }

    public function deleteAskServiceMobileAction($id){
        $em = $this->getDoctrine()->getManager();
        $askService=$em->getRepository(AskService::class)->find($id);
        $jb = $this->getDoctrine()->getManager();
        $job=$jb->getRepository(Job::class)->findOneBy(['askService'=>$id]);
        if(!$job==null){
            $em->remove($job);
            $em->flush();
        }
        $em->remove($askService);
        $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted=$serializer->normalize($askService);
        return new JsonResponse($formatted);
    }


    public function payAskServiceMobileAction($id){
        $repository = $this->getDoctrine()->getRepository(AskService::class);
        $askService = $repository->findOneBy(['ask_service_id'=>$id]);
        $askService->setStatus('Confirmed');
        $em=$this->getDoctrine()->getManager();
        $em->persist($askService);
        $em->flush();

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted=$serializer->normalize($askService);
        return new JsonResponse($formatted);
    }

    public function addAskServiceMobileAction($idUser,$desc,$price,$dur,$service,$stated)
    {


        $idUsers = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $idUser]);

        $askService = new AskService();
        $em = $this->getDoctrine()->getManager();

        $askService->setUser($idUsers);
        $askService->setDescription($desc);
        $askService->setPrice($price);
        $askService->setDuration($dur);
        $askService->setServiceName($service);
        $askService->setStartedAt($stated);
        $em->persist($askService);

        $em->flush();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers);
        $formatted=$serializer->normalize($askService);
        return new JsonResponse($formatted);
    }


}
