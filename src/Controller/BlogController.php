<?php

namespace App\Controller;
use App\Form\CreatePostFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Posts;
use Symfony\Component\String\Slugger\SluggerInterface;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        $posts = $entityManager->getRepository(Posts::class)->findAll();
        return $this->render('blog/index.html.twig',
            ['posts' => $posts]
        );
    }

    #[Route('/blog/{slug}', name: 'app_post_detail')]
    public function post($slug, EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger): \Symfony\Component\HttpFoundation\Response
    {
        $post = $entityManager->getRepository(Posts::class)->findOneBy(['slug' => $slug]);
        if (!$post && $slug !== 'create') {
            throw $this->createNotFoundException('The post does not exist');
        } elseif ($slug == 'create') {
            $post = new Posts();
            $form = $this->createForm(CreatePostFormType::class, $post);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $post->setSlug($slugger->slug($post->getName()));
                $entityManager->persist($post);
                $entityManager->flush();
                return $this->redirectToRoute('app_blog');
            }
            return $this->render('blog/create.html.twig', ['form' => $form->createView()]);
        } else {
            return $this->render('blog/post.html.twig',
                ['slug' => $slug,
                    'post' => $post]
            );
        }
    }
}