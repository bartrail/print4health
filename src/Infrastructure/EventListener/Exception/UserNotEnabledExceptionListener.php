<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener\Exception;

use App\Domain\Exception\Security\UserNotEnabledException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Throwable;

class UserNotEnabledExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        /** @var UserNotEnabledException|Throwable $exception */
        $exception = $event->getThrowable();

        if (false === $exception instanceof UserNotEnabledException) {
            return;
        }

        $response = new JsonResponse([
            'error' => $exception->getMessage(),
        ], Response::HTTP_UNAUTHORIZED);

        $event->setResponse($response);
    }
}
