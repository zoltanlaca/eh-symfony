<?php

namespace Isklad\EgonErrorHandlerBundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

class EgonErrorHandlerBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $containerBuilder): void
    {
        $container->import('../config/services.yaml');
        //$containerConfigurator->import('../config/packages/egon_error_handler.yaml');
    }
}