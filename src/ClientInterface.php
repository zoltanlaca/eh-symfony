<?php

namespace Zoltanlaca\EhSymfony;

interface ClientInterface
{
    public function push(\Throwable $throwable): void;
}