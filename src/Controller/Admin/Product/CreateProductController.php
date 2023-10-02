<?php

namespace App\Controller\Admin\Product;

use App\Form\ProductType;
use App\Product\ProductFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

#[AsController()]
class CreateProductController
{
    public function __construct(
        private readonly Environment $twig,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface $formFactory,
        private readonly ProductFactory $productFactory,
    ) {}

    #[Route(path: '/admin/products/new', name: 'admin_products_new', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productDto = $form->getData();
            $product = $this->productFactory->create($productDto);

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return new RedirectResponse($this->urlGenerator->generate('admin_products_list'));
        }

        return new Response($this->twig->render(
            name: 'products/new.html.twig',
            context: [
                'create_form' => $form->createView(),
            ]
        ));
    }
}