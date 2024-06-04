<?php

namespace App\Controller;


use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductType;


class ProductController extends AbstractController
{
    #[NoReturn] #[Route('/product',
        name: 'app_product',
        methods: ['GET'],
    )]

    public function index(EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        $products = $entityManager ->getRepository(Products::class) ->findAll();

        return $this ->render('products/index.html.twig',[
            'products' => $products,

            ]);
    }

    #[Route('/product/{id}',
        name: 'app_product_show',
        methods: ['GET'],
    )]
    public function show($id ,EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        $product = $entityManager ->getRepository(Products::class) ->find($id);

        if (is_null($product)){
            return $this ->redirectToRoute('app_product');
        }

        return $this ->render('products/show.html.twig', [
            'id' => $id,
            'product' => $product,

        ]);
    }

    #[Route('/create',
        name: 'app_product_create',
        methods: ['GET', 'POST'],
    )]
    public function create (Request $request, EntityManagerInterface $manager): \Symfony\Component\HttpFoundation\Response
    {
        $product = new Products();
        $form = $this ->createForm(ProductType::class, $product);
        $form ->handleRequest($request);

        if ($form ->isSubmitted() && $form ->isValid()) {
            $manager ->persist($product);
            $manager ->flush();

            return $this ->redirectToRoute('app_product');
        }

        return $this ->render('products/create.html.twig', [
            'form' => $form ->createView(),
        ]);
    }

}