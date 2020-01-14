<?php

namespace fixitBundle\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Category;
use AppBundle\Entity\Service;
use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ServiceType;
class AdminController extends Controller
{
    public function homeAdminAction()
    {
//        return $this->render('@Service/AddCategory.html.twig');
        $Category = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('@fixit/homeAdmin.html.twig', array('Category' => $Category));
    }

    public function AddCategoryAction(Request $request)
    {
        $Category = new Category();
        $f = $this->createForm(CategoryType::class, $Category);
        $f = $f->handleRequest($request);
        if ($f->isValid()) {
            $file = $request->files->get('appbundle_category')['image'];
            $uploads_directory = $this->getParameter('uploads_directory');

            $fileName = $file->getClientOriginalName();

            $file->move($uploads_directory, $fileName);
            $Category->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Category);
            $em->flush();
            $Category = $this->getDoctrine()->getRepository(Category::class)->findAll();
            return $this->redirectToRoute('admin_homepage');
        }
        return $this->render('@fixit/AddCategory.html.twig', array('f' => $f->createView()));
        $this->addFlash("success", "projet creer avec succee");
    }

    public function deleteCategoryAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Category = $em->getRepository(Category::class)->find($id);
        $em->remove($Category);
        $em->flush();
        return $this->redirectToRoute("admin_homepage");


    }

    public function UpdateCategoryAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $file1 = $request->files->get('appbundle_category')['image'];
            $uploads_directory = $this->getParameter('uploads_directory');

            $fileName = $file1->getClientOriginalName();

            $file1->move($uploads_directory, $fileName);
            $category->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('admin_homepage');
        }
        return $this->render('@fixit/AddCategory.html.twig', array('f' => $form->createView()));

    }

    public function AddServiceAction(Request $request)
    {
        $Service = new Service();
        $form = $this->createForm(ServiceType::class, $Service);
        $form = $form->handleRequest($request);
        $Service->setNote(2);
        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($Service);
            $em->flush();
            return $this->redirectToRoute('admin_homepage');        }
        return $this->render('@fixit/create2.html.twig', array('f' => $form->createView()));
    }

    public function afficheServiceAction($id)
    {
        $cat=$this->getDoctrine()->getRepository(Category::class)->findOneBy(['category_id'=>$id]);

        $Service=$this->getDoctrine()->getRepository(Service::class)->findBy(['category'=>$cat]);

            return $this->render('@fixit/detail2.html.twig', array('Service' => $Service));

    }

    public function deleteServiceAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $service = $em->getRepository(Service::class)->find($id);

        $em->remove($service);
        $em->flush();
        return $this->redirectToRoute("admin_homepage");
    }

    public function UpdateServiceAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $service = $em->getRepository(Service::class)->find($id);
        $form = $this->createForm(ServiceType::class, $service);
        $form = $form->handleRequest($request);
        if ($form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $em->persist($service);
        $em->flush();
        return $this->redirectToRoute('admin_homepage');}

        return $this->render('@fixit/create2.html.twig', array('f' => $form->createView()));

    }
}