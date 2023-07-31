<?php

namespace Isklad\EgonErrorHandlerBundle;

class Client implements ClientInterface
{
    public function push(\Throwable $throwable): void
    {
        dd('push');
        dd('som v Client - ' . $exception->getMessage());
    }
}