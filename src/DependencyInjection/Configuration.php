<?php
namespace PhpDDD\PhpDDDBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('php_ddd');

        $rootNode
            ->children()
                ->booleanNode('event')->defaultTrue()->end()
                ->booleanNode('command')->defaultTrue()->end()
            ->end();

        return $treeBuilder;
    }
}
