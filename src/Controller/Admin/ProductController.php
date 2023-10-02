<?php

namespace App\Controller\Admin;

use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route(path: '/admin/products', name: 'admin_products_list', methods: ['GET'])]
    public function listProducts(): Response
    {
        /** @var ProductRepository $productRepository */
        $productRepository = $this->container->get(ProductRepository::class);
        $twig = $this->container->get('twig');

        return new Response($twig->render(
            name: 'products/list.html.twig',
            context: [
                'products' => $productRepository->findAll(),
            ]
        ));
    }

    #[Route(path: '/admin/products/new', name: 'admin_products_new', methods: ['GET', 'POST'])]
    public function addProduct(Request $request): Response
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $entityManager = $this->container->get('doctrine.orm.entity_manager');
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('admin_products_list');
        }

        $twig = $this->container->get('twig');

        return new Response($twig->render(
            name: 'products/new.html.twig',
            context: [
                'create_form' => $form->createView(),
            ]
        ));
    }

    public static function getSubscribedServices(): array
    {
        return array_merge(
            parent::getSubscribedServices(),
            [
                'doctrine.orm.entity_manager' => '?'.EntityManagerInterface::class,
                ProductRepository::class => ProductRepository::class,
            ]
        );
    }
}