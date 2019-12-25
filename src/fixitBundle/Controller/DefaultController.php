<?php

namespace fixitBundle\Controller;
use AppBundle\Entity\Ad;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
      //  $role = $this->get('security.token_storage')->getToken()->getUser()->getRoles();


        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            $authChecker = $this->container->get('security.authorization_checker');
            $router = $this->container->get('router');
            if ($authChecker->isGranted('ROLE_ADMIN')) {
                return new RedirectResponse($router->generate('admin_homepage'), 307);
            }
            if ($authChecker->isGranted('ROLE_PROVIDER')) {
                return new RedirectResponse($router->generate('provider_homepage'), 307);
            }
            if ($authChecker->isGranted('ROLE_CLIENT')) {
                return new RedirectResponse($router->generate('client_homepage'), 307);
            }

        }
        else
        return $this->render('@fixit/Default/index.html.twig');

    }



    public function showAllAdAction(Request $request)
    {   //fetching Objects (ad) from the DataBase
        $ad=$this->getDoctrine()->getRepository(Ad::class)->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result=$paginator->paginate(
            $ad,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3));
        return $this->render('@fixit/Default/adminShowAd.html.twig',array('ads'=>$result));
    }

    public function deleteAdAction($ad_id)
    {
        $em= $this->getDoctrine()->getManager();
        $ad=$em->getRepository(Ad::class)->find($ad_id);
        $em->remove($ad);
        $em->flush();
        return $this->redirectToRoute("admin_showad");
    }

}
