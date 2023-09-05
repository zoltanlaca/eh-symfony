<?php

namespace Zoltanlaca\EhSymfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class EgonErrorHandlerConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('egon_error_handler');
        $treeBuilder->getRootNode()
            ->fixXmlConfig('excluded_exception')
            ->children()
            ->arrayNode('excluded_exceptions')
            ->scalarPrototype()->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}