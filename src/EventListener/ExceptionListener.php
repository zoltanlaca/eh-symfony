<?php

namespace Isklad\EgonErrorHandlerBundle\EventListener;

use Isklad\EgonErrorHandlerBundle\ClientInterface;
use Isklad\EgonErrorHandlerBundle\Handler;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{

    public function __construct(private readonly Handler $handler)
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $this->handler->push($exception);
    }
}