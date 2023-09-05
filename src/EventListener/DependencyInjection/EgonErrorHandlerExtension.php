<?php

namespace Zoltanlaca\EhSymfony\EventListener\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class EgonErrorHandlerExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        // ... you'll load the files here later
    }
}