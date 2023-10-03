<?php

namespace App\Controller\Api\Product;

use App\Product\ProductCreatorFacade;
use App\Product\ProductDto;
use App\Product\ProductFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController()]
class CreateProductController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ProductCreatorFacade $productCreator,
    ) {}

    #[Route(path: '/api/products', name: 'api_products_new', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $productDto = $this->serializer->deserialize($request->getContent(), ProductDto::class, 'json');

        $product = $this->productCreator->create($productDto);

        return JsonResponse::fromJsonString(
            data: $this->serializer->serialize($product, 'json'),
            status: JsonResponse::HTTP_OK
        );
    }
}