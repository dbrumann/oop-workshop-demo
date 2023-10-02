<?php

namespace App\Controller\Api\Product;

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
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $entityManager,
        private readonly ProductFactory $productFactory,
    ) {}

    #[Route(path: '/api/products', name: 'api_products_new', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $productDto = $this->serializer->deserialize($request->getContent(), ProductDto::class, 'json');
        $errors = $this->validator->validate($productDto);
        if (count($errors) > 0) {
            return JsonResponse::fromJsonString(
                data: $this->serializer->serialize($errors, 'json'),
                status: JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $product = $this->productFactory->create($productDto);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return JsonResponse::fromJsonString(
            data: $this->serializer->serialize($product, 'json'),
            status: JsonResponse::HTTP_OK
        );
    }
}