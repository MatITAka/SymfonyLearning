<?php

namespace App\Controller;
use App\Form\CreatePostFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Posts;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Form\ModifyPostFormType;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        $posts = $entityManager->getRepository(Posts::class)->findBy(['published' => true]);

        if (!$posts) {
            throw $this->createNotFoundException('No posts found');
        }
        return $this->render('blog/index.html.twig',
            ['posts' => $posts]
        );
    }

    #[Route('/blog/create', name: 'app_post_create')]
    public function create(EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger): \Symfony\Component\HttpFoundation\Response
    {
        $post = new Posts();
        $form = $this->createForm(CreatePostFormType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug($slugger->slug($post->getName()));
            $post->setCreatedAt(new \DateTime());
            $post->setPublished(true);
            $post->setUpdatedAt(new \DateTime());
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('app_post_detail', ['slug' => $post->getSlug()]);
        }
        return $this->render('blog/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/blog/{slug}/edit', name: 'app_post_edit')]
    public function edit($slug, EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger): \Symfony\Component\HttpFoundation\Response
    {
        $post = $entityManager->getRepository(Posts::class)->findOneBy(['slug' => $slug]);
        $form = $this->createForm(ModifyPostFormType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug($slugger->slug($post->getName()));
            $post->setContent($post->getContent());
            $post->setName($post->getName());
            $post->setPublished($post->isPublished());
            $post->setDescription($post->getDescription());
            $post->setUpdatedAt(new \DateTime());
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('app_post_detail', ['slug' => $post->getSlug()]);
        }
        return $this->render('blog/modify.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/blog/{slug}/delete', name: 'app_post_delete')]
    public function delete($slug, EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        $post = $entityManager->getRepository(Posts::class)->findOneBy(['slug' => $slug]);
        $entityManager->remove($post);
        $entityManager->flush();
        return $this->redirectToRoute('app_blog');
    }

    #[Route('/blog/{slug}', name: 'app_post_detail')]
    public function post($slug, EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger): \Symfony\Component\HttpFoundation\Response
    {
        $post = $entityManager->getRepository(Posts::class)->findOneBy(['slug' => $slug]);
        if (!$post && $slug !== 'create') {
            throw $this->createNotFoundException('The post does not exist');
        } else {
            return $this->render('blog/post.html.twig',
                ['slug' => $slug,
                    'post' => $post]
            );
        }
    }


}