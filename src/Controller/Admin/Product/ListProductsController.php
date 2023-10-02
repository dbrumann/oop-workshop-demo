<?php

namespace App\Controller\Admin\Product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[AsController()]
class ListProductsController
{
    public function __construct(
        private readonly Environment $twig,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    #[Route(path: '/admin/products', name: 'admin_products_list', methods: ['GET'])]
    public function listProducts(): Response
    {
        $productRepository = $this->entityManager->getRepository(Product::class);

        return new Response($this->twig->render(
            name: 'products/list.html.twig',
            context: [
                'products' => $productRepository->findAll(),
            ]
        ));
    }
}