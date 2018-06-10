<?php

namespace Alala\TmdbBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Alala\TmdbBundle\Enum\TmdbChoices;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{ 
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {        
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('alala_tmdb');
        
        $rootNode
            ->children()
                ->scalarNode('url')
                    ->defaultValue('https://api.themoviedb.org/3/')
                ->end()
                ->scalarNode('apikey')
                    ->isRequired()
                ->end()
                ->scalarNode('movie_parser_service')
                ->end()
                ->scalarNode('language')
                    ->defaultValue('fr-FR')
                ->end()
                ->arrayNode('discover')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('sortby')
                            ->values(TmdbChoices::SORT_BY_MOVIE)
                            ->defaultValue(TmdbChoices::SORT_BY_MOVIE[1])
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
