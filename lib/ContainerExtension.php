<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\ConnectionCollection;
use ICanBoogie\ActiveRecord\ConnectionProvider;
use ICanBoogie\ActiveRecord\ModelCollection;
use ICanBoogie\ActiveRecord\ModelProvider;
use ICanBoogie\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class ContainerExtension extends Extension
{
    /**
     * @param array<string, mixed> $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->register_connection_provider($container);
        $this->register_model_provider($container);
    }

    private function register_connection_provider(ContainerBuilder $container): void
    {
        $definition = (new Definition(ConnectionCollection::class))
            ->setFactory([ Hooks::class, 'app_lazy_get_connections' ])
            ->setArguments([ new Reference(Application::class)]);

        $container->setDefinition(ConnectionProvider::class, $definition);
    }

    private function register_model_provider(ContainerBuilder $container): void
    {
        $definition = (new Definition(ModelCollection::class))
            ->setFactory([ Hooks::class, 'app_lazy_get_models' ])
            ->setArguments([ new Reference(Application::class)]);

        $container->setDefinition(ModelProvider::class, $definition);
    }
//
//  private function register_connections(Config $config, ContainerBuilder $container): void
//  {
//      foreach ($config->connections as $id => $connection) {
//          $definition = (new Definition(Connection::class))
//              ->setFactory([ new Reference(ConnectionProvider::class), 'connection_for_id' ])
//              ->setPublic(true)
//              ->setArguments([ $id ]);
//
//          $container->setDefinition("active_record.connection.$id", $definition);
//      }
//  }
}
