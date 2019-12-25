<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Categoryt;
use AppBundle\Form\CategorytType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategorytController extends Controller
{


    public function deleteAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $categ=$em->getRepository(Categoryt::class)->find($id);
        $em->remove($categ);
        $em->flush();
        return $this->redirectToRoute("show_ticket");
    }


}
