<?php

namespace ClientBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;




class PostController extends Controller
{
    public function listAction()
    {
       // $post = $this->getDoctrine()->getRepository(Post::class)->findAll();

        $em = $this->getDoctrine()->getManager()->getRepository(Post::class);

        $post = $em->findname();
        $idUser=$this->get('security.token_storage')->getToken()->getUser();

        return $this->render('@Client/Default/forum.html.twig', array('P' => $post,'C'=>$idUser));

    }


    public function CreateAction(Request $request)
    {
        $Form = new Post();
        $form = $this->createForm(PostType::class, $Form);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $Form->setUser($this->get('security.token_storage')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($Form);
            $em->flush();
            return $this->redirectToRoute('client_forum');
        }
        return $this->render('@Client/Default/createPost.html.twig', array('f' => $form->createView()));
    }

    public function editPostAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Post::class)->find($id);
        $form = $this->createForm(PostType::class, $club);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('client_forum');
        }
        return $this->render('@Client/Default/createPost.html.twig', array('f' => $form->createView()));
    }


//
    public function deletePostAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('client_forum');
    }
    public function testAction(){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $em = $this->getDoctrine()->getManager()->getRepository(Post::class);

        $post = $em->findname();
        $idUser=$this->get('security.token_storage')->getToken()->getUser();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('@Client/Default/test.html.twig', array('P' => $post,'C'=>$idUser));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        $publicDirectory = $this->get('kernel')->getProjectDir() . '/web/pdf';
        // e.g /var/www/project/public/mypdf.pdf
        $pdfFilepath =  $publicDirectory . '/mypdf.pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);

        // Send some text response
        return new Response("The PDF file has been succesfully generated !");
    }
}