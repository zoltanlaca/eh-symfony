<?php

namespace Isklad\EgonErrorHandlerBundle;

interface ClientInterface
{
    public function push(\Throwable $throwable): void;
}