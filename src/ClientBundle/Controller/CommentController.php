<?php

namespace ClientBundle\Controller;

use AppBundle\Entity\Comments;
use AppBundle\Entity\Post;

use AppBundle\Form\CommentsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CommentController extends Controller
{
    public function listAction($id)
   {
        $comment = $this->getDoctrine()->getManager()->getRepository(Comments::class);
       $comments=$comment->findBy(['idPost'=>$id]);

       $post = $this->getDoctrine()->getManager()->getRepository(Post::class);
       $posts=$post->findOneBy(['post_id'=>$id]);

        return $this->render('@Client/Default/comments.html.twig', array(
            'C'=>$comments,'p'=>$posts));

    }


    public function createAction(Request $request, $id)
    {
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form = $form->handleRequest($request);
        $comment->setUser($this->get('security.token_storage')->getToken()->getUser());
        $idPosts = $this->getDoctrine()->getRepository(Post::class)->findOneBy(['post_id' => $id]);
        if ($form->isValid()) {
            $comment->setIdPost($idPosts);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('client_forum');
        }
        return $this->render('@Client/Default/createComment.html.twig', array('f' => $form->createView()));
    }

//    public function update1Action($id, Request $request)
//    {
//
//        $em = $this->getDoctrine()->getManager();
//        $comment = $em->getRepository(Comments::class)->find($id);
//        $form = $this->createForm(CommentsType::class, $comment);
//        $form = $form->handleRequest($request);
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($comment);
//            $em->flush();
//            return $this->redirectToRoute('comment_list1');
//        }
//        return $this->render('@Forum/Forum/create1.html.twig', array('f' => $form->createView()));
//    }
//
//
    public function deleteCommentAction ($id)
    {


        $em = $this->getDoctrine()->getManager();
        $comment = $this->getDoctrine()->getRepository(Comments::class)->find($id);
        $em->remove($comment);
        $em->flush();
      return $this->redirectToRoute('client_forum');
     // return $this->redirectToRoute('client_showComment', ['post_id' => $id]);

        //return $this->redirect('http://localhost/fixit/web/app_dev.php/client/showComment', array('post_id' => $id));


    }

}
