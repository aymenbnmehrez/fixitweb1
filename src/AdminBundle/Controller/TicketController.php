<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Categoryt;
use AppBundle\Entity\Ticket;
use AppBundle\Form\CategorytType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

class TicketController extends Controller
{
    public function showTicketAction(Request $request)
    { $categAll=$this->getDoctrine()->getRepository(Categoryt::class)->findAll();

        $categ = new Categoryt();
        $form = $this->createForm(CategorytType::class, $categ);
        $form->handleRequest($request);
        if( $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categ);
            $em->flush();
        }

        $rep=$this->getDoctrine()->getManager()->getRepository(Ticket::class)->findAll();

        return $this->render('@Admin/Tickets/show.html.twig', array('listTicket'=>$rep,'categ'=>$categAll,'f' =>$form->createView()));
    }
    public function ArchiveTicketAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $ticket=$em->getRepository(Ticket::class)->find($id);
        $ticket->setStatus('Archived');
        $em->persist($ticket);
        $em->flush();
        return $this->redirectToRoute("show_ticket");
    }




    public function TreatAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();

        $ticket=$em->getRepository(Ticket::class)->find($id);

        $ticket->setStatus('Treated');
        $em->persist($ticket);
        $em->flush();

        $form = $this->createFormBuilder()
            ->add('message', TextareaType::class)
            ->add('send', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        $message = $form["message"]->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $email=$ticket->getUser()->getEmail();

                $message = $form["message"]->getData();
                $message = \Swift_Message::newInstance()
                    ->setSubject('Fixit Claim')
                    ->setFrom('ApplFixit@gmail.com')
                    ->setTo($email)
                    ->setCharset('utf-8')
                    ->setContentType('text/html')
                    ->setBody($message);
                $this->get('mailer')->send($message);

            }
        }
        $rep=$this->getDoctrine()->getManager()->getRepository(Ticket::class)->find($id);
        return $this->render('@Admin/Tickets/SendMail.html.twig',array('T'=>$rep,'message'=>$message,'mail'=>$form->createView()));
    }
}
