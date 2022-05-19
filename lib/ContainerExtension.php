<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Connection;
use ICanBoogie\ActiveRecord\ConnectionProvider;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\ModelProvider;
use ICanBoogie\Application;
use ICanBoogie\Binding\SymfonyDependencyInjection\ExtensionWithFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Reference;

use function is_string;

final class ContainerExtension extends Extension implements ExtensionWithFactory
{
    public static function from(Application $app): ExtensionInterface
    {
        return new self(
            $app->configs->config_for_class(Config::class)
        );
    }

    private function __construct(
        private readonly Config $config
    ) {
    }

    /**
     * @param array<string, mixed> $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->register_connections($container);
        $this->register_models($container);
    }

    private function register_connections(ContainerBuilder $container): void
    {
        foreach ($this->config->connections as $id => $connection) {
            $definition = (new Definition(Connection::class))
                ->setFactory([ new Reference(ConnectionProvider::class), 'connection_for_id' ])
                ->setArguments([ $id ])
                ->setPublic(true);

            $container->setDefinition("active_record.connection.$id", $definition);
        }
    }

    private function register_models(ContainerBuilder $container): void
    {
        foreach ($this->config->models as $id => $model) {
            $class = $model[Model::CLASSNAME] ?? Model::class;

            assert(is_string($class));

            $definition = (new Definition($class))
                ->setFactory([ new Reference(ModelProvider::class), 'model_for_id' ])
                ->setArguments([ $id ])
                ->setPublic(true);

            $alias = "active_record.model.$id";

            if ($class === Model::class) {
                $container->setDefinition($alias, $definition);
            } else {
                $container->setDefinition($class, $definition);
                $container->setAlias($alias, $class);
            }
        }
    }
}
