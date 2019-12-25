<?php

namespace fixitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use AppBundle\Repository\CheckProviderRepository;
use UserBundle\Entity\User;

class CheckProviderController extends Controller
{
    public function checkProviderAction(){


        $providers = $this->get('fos_user.user_manager');
        $users = $providers->findUsers();

        return $this->render('@fixit/checkProvider.html.twig',array('prov'=>$users));

    }
    public function confirmProviderAction($id){
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['id'=>$id]);
        $user->setStatus('Confirmed');
        $em=$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("admin_homepage");

    }

}
