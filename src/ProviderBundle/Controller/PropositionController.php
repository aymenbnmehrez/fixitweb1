<?php

namespace ProviderBundle\Controller;

use AppBundle\Entity\Proposition;
use AppBundle\Form\PropositionType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;


class PropositionController extends Controller
{

    public function AddPropositionAction(Request $request)
    {
        $propo = new Proposition();
        $form = $this->createForm(PropositionType::class, $propo);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($propo);
            $em->flush();
            return $this->redirectToRoute('provider_profilepage');        }
        return $this->render('@Provider/Default/proposition.html.twig', array('f' => $form->createView()));
    }

}