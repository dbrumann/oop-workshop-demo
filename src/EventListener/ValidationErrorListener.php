<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[AsEventListener(event: ExceptionEvent::class)]
class ValidationErrorListener
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {}

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        if (!$throwable instanceof ValidationFailedException) {
            return;
        }

        $errorResponse = JsonResponse::fromJsonString(
            data: $this->serializer->serialize($throwable->getViolations(), 'json'),
            status: JsonResponse::HTTP_BAD_REQUEST
        );

        $event->setResponse($errorResponse);
    }
}