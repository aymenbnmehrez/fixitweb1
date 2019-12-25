<?php

namespace ClientBundle\Controller;

use AppBundle\Entity\Categoryt;
use AppBundle\Entity\Ticket;
use AppBundle\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;


class TicketController extends Controller
{
    public function createTicketAction(Request $request)//$id
    {   $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);

//$id=$ticket->getCategoryt()->getId();
        $em=$this->getDoctrine()->getManager();
        $categ=$em->getRepository(Categoryt::class)->findOneBy(['id'=>2]);
        //$categ=$em->getRepository(Categoryt::class)->findOneBy(['id'=>1]);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file=$ticket->getImage();
            //$fileName= md5(uniqid()).'.'.$file->guessExtension();
            $fileName = $file->getClientOriginalName();
            $file->move($this->getParameter('uploads_directory'),$fileName);
            $ticket->setImage($fileName);
            $ticket->setUser($this->get('security.token_storage')->getToken()->getUser()); //
            $ticket->setCategoryt($categ);
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();

            return $this->redirectToRoute('client_displayservice');
        }

        return $this->render('@Client/Tickets/addT.html.twig',array('form' => $form->createView()));
    }
}
