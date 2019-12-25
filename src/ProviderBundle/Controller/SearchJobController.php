<?php

namespace ProviderBundle\Controller;

use AppBundle\Entity\AskService;
use AppBundle\Entity\Image;
use AppBundle\Entity\Job;
use AppBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchJobController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Provider/Default/searchjob.html.twig');
    }
    public function displayJobAction()
    {
        //$user = $this->get('security.token_storage')->getToken()->getUser();
        //   $id=$user->getId();
        $repository = $this->getDoctrine()->getRepository(AskService::class);
        $askService = $repository->findAll();

        return $this->render('@Provider/Default/searchjob.html.twig', array('as' => $askService));
    }
    public function confirmJobAction($id){
        $job=new Job();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $repository = $this->getDoctrine()->getRepository(AskService::class);
        $askService = $repository->findOneBy(['ask_service_id'=>$id]);
        $askService->setStatus('Waiting');
        $job->setUser($user);
        $job->setAskService($askService);
        $em=$this->getDoctrine()->getManager();
        $em->persist($askService);
        $em->persist($job);
        $em->flush();
        return $this->redirectToRoute('provider_searchjob');
    }
    public function jobrequestsAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        //$id=$user->getId();
        $repository = $this->getDoctrine()->getRepository(Job::class);
        $job = $repository->findBy(['user'=>$user]);

        return $this->render('@Provider/Default/myjobrequests.html.twig', array('jb' => $job));
    }
    public function canceljobAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $job=$em->getRepository(Job::class)->find($id);
        $idask=$job->getAskService()->getAskServiceId();
        $em->remove($job);
        $repository = $this->getDoctrine()->getRepository(AskService::class);
        $askService = $repository->findOneBy(['ask_service_id'=>$idask]);
        $askService->setStatus('Not Confirmed');
        $em->flush();
        return $this->redirectToRoute('provider_jobrequests');
    }
    public function profileAction()
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $iduser=$user->getId();
        $repository = $this->getDoctrine()->getRepository(Image::class);
        $image = $repository->findOneBy(['user'=>$iduser]);
        return $this->render('@Provider/Default/profile.html.twig', array('u' => $user,'i'=>$image));
    }
    public function setImageAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $iduser=$user->getId();
        $image = new Image();
        $f = $this->createForm(ImageType::class, $image);
        $f = $f->handleRequest($request);
        $rep = $this->getDoctrine()->getManager();
        $oldImg=$rep->getRepository(Image::class)->findOneBy(['user'=>$iduser]);
        if(!$oldImg==null) {
            $rep->remove($oldImg);
            $rep->flush();
        }
        if ($f->isValid()) {

            $file = $request->files->get('appbundle_image')['image'];
            $uploads_directory = $this->getParameter('uploads_directory');

            $fileName = $file->getClientOriginalName();

            $file->move($uploads_directory, $fileName);
            $image->setImage($fileName);
            $image->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();
            return $this->redirectToRoute('provider_profilepage');
        }
        return $this->render('@Provider/Default/setimage.html.twig', array('f' => $f->createView()));
        $this->addFlash("success", "projet creer avec succee");

    }

}
