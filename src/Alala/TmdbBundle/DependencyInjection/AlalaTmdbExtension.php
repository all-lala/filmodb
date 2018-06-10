<?php

namespace Alala\TmdbBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class AlalaTmdbExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        $serviceDefintion = $container->getDefinition( 'console.command.alala_tmbd.movie' );
        $serviceDefintion->replaceArgument('$configs', $config);
        
        if(isset($config['movie_parser_service'])){
            $serviceDefintion->replaceArgument('$localMovie', new Reference($config['movie_parser_service']));
        }
        
        $serviceDefintion = $container->getDefinition( 'alala_tmdb.query' );
        $serviceDefintion->addArgument($config);
    }
}
