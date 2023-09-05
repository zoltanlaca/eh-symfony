<?php

namespace Zoltanlaca\EhSymfony\EventListener;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Zoltanlaca\EhSymfony\ClientInterface;
use Zoltanlaca\EhSymfony\DependencyInjection\EgonErrorHandlerConfiguration;
use Zoltanlaca\EhSymfony\Handler;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function __construct(private readonly Handler $handler, EgonErrorHandlerConfiguration $configurator)
    {
        dd($configurator);
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $this->handler->push($exception);
    }
}