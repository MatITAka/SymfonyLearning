<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
    #[Route('/product',
        name: 'app_product',
        methods: ['GET'],
    )]

    public function index()
    {
        return $this ->render('products/index.html.twig');
    }

    #[Route('/product/{id}',
        name: 'product_show',
        methods: ['GET'],
    )]
    public function show($id)
    {
        return $this ->render('products/show.html.twig', ['id' => $id]);
    }

    #[Route('/product/{id}/edit',
        name: 'product_edit',
        methods: ['GET', 'POST'],
    )]
    public function edit($id)
    {
        return $this ->render('products/edit.html.twig', ['id' => $id]);
    }

    #[Route('/product/{id}/delete',
        name: 'product_delete',
        methods: ['DELETE'],
    )]

    public function delete($id)
    {
        return $this ->render('products/delete.html.twig', ['id' => $id]);
    }
}