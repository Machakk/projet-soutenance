<?php

namespace App\Controller;

use App\Entity\Users;
use DateTimeInterface;
use App\Form\PostsType;
use App\Entity\PostForum;
use App\Repository\PostForumRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostsAdminController extends AbstractController
{
    /**
     * @Route("/admin/posts", name="admin_posts")
     */
    public function index(PostForumRepository $postForumRepository): Response
    {
        $posts = $postForumRepository->findAll();
        return $this->render('admin/posts.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/admin/posts/create", name="post_create")
     */
    public function createPost(Request $request){
        // $user = new Users();
        
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        
        $post = new PostForum();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $infoImg = $form['img']->getData();
            if($infoImg !=null){

                $extebsionImg = $infoImg->guessExtension();
                $nomImg = '1-'. time() .'.'. $extebsionImg;// compose un nom d'image unique
                $infoImg->move($this->getParameter('photos_posts') ,$nomImg); //déplace l'image dans le dossier
     
                $post->setImg($nomImg);
            }
            $date = new \DateTime('@'.strtotime('now'));
            $post->setDate($date);
            $post->setUser($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('admin_posts');
            //métier modifié
        }
        return $this->render('admin/postsForm.html.twig', [
            'postsForm'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/admin/posts/update-{id}", name="post_update")
     */
    public function updatePosts(PostForumRepository $postForumRepository, $id, Request $request)
    {
        $post = $postForumRepository->find($id);
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $oldNomImg1 = $post->getImg();
            if($oldNomImg1 !=null){

                $oldCheminImg1 = $this->getParameter('photos_posts') . '/' . $oldNomImg1;       
                if (file_exists($oldCheminImg1)) 
                {
                    unlink($oldCheminImg1);
                }
            }
           
            $infoImg1 = $form['img']->getData();
            if($infoImg1 !=null){
                
                $extensionImg1 = $infoImg1->guessExtension();
                $nomImg1 = '1-' . time() . '.' . $extensionImg1;
                $infoImg1->move($this->getParameter('photos_posts'), $nomImg1);
                $post->setImg($nomImg1);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
            $this->addFlash('success', 'Le post a été modifié');
            return $this->redirectToRoute('admin_posts');
        }
        return $this->render('admin/postsForm.html.twig', [
            'postsForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/posts/delete-{id}", name="post_delete")
     */
    public function deletePosts(PostForumRepository $postForumRepository, $id) {
        $post = $postForumRepository->find($id);
        $oldNomImg1 = $post->getImg();
        $oldCheminImg1 = $this->getParameter('photos_posts') . '/' . $oldNomImg1;
        if ($oldNomImg1 != null) {
            unlink($oldCheminImg1);
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($post);
        $manager->flush();
     
        return $this->redirectToRoute('admin_posts');
    }








  
}
