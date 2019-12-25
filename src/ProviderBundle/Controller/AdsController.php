<?php

namespace ProviderBundle\Controller;

use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AdType;
use AppBundle\Entity\Ad;

class AdsController extends Controller
{

    public function addAdAction(Request $request)
    {

        $ad=new Ad();
        $form=$this->createForm(AdType::class,$ad);
        $form=$form->handleRequest($request);
        if ($form->isValid()){
            $user=$this->container->get('security.token_storage')->getToken()->getUser();
            $ad->setUser($user);
            $ad->setPublishedAt(date_create());
            $file=$request->files->get('appbundle_ad')['image'];
            $uploads_directory=$this->getParameter('uploads_directory');

            $fileName = $file->getClientOriginalName();

            $file->move($uploads_directory,$fileName);
            $ad->setImage($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($ad);
            $em->flush();
            return $this->redirectToRoute('provider_addAd');
        }

        return $this->render('@Provider/Default/ad.html.twig',array('form'=>$form->createView()));

    }

    public function deleteAdAction($ad_id)
    {
        $em= $this->getDoctrine()->getManager();
        $ad=$em->getRepository(Ad::class)->find($ad_id);
        $em->remove($ad);
        $em->flush();
        return $this->redirectToRoute("provider_showAd");
    }

    public function updateAdAction($ad_id ,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $ad=$em->getRepository(Ad::class)->find($ad_id);
        $image=$ad->getImage();
        $ad->setImage("az");
        $form=$this->createForm(AdType::class,$ad);
        $form=$form->handleRequest($request);
        if ($form->isValid()){

            if ($ad->getImage()=="az" && $request->files->get('appbundle_ad')['image']==null ) {

                $ad->setImage($image);
                $em->persist($ad);
                $em->flush();
                return $this->redirectToRoute("provider_showAd");

            }

            $file= $request->files->get('appbundle_ad')['image'];
            $uploads_directory=$this->getParameter('uploads_directory');
            $image=$file->getClientoriginalName();
            $file->move($uploads_directory,$image);
            $ad->setImage($image);
            $em->persist($ad);
            $em->flush();
            return $this->redirectToRoute("provider_showAd");
        }

        return $this->render('@Provider/Default/updateAd.html.twig',array('form'=>$form->createView()));
    }

    public function showMyAdsAction(Request $request)
    {   //fetching Objects (ad) from the DataBase
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $ad=$this->getDoctrine()->getRepository(Ad::class)->findBy(['user' => $user]);


        $paginator=$this->get('knp_paginator');
        $result=$paginator->paginate(
            $ad,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',5));
        return $this->render('@Provider/Default/showad.html.twig',array('ads'=>$result));
    }

}