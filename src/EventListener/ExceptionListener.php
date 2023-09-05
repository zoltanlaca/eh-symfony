<?php

namespace Zoltanlaca\EhSymfony\EventListener;

use Zoltanlaca\EhSymfony\ClientInterface;
use Zoltanlaca\EhSymfony\Handler;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{

    /**
     * @var array|string[]
     */
    private array $skipExceptions;

    public function __construct(private readonly Handler $handler)
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (in_array(get_class($exception), $this->skipExceptions)) {
            return;
        }

        $this->handler->push($exception);
    }
}