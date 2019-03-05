<?php

/**
 * Redis transport implementation module.
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\Transport\Module\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use ServiceBus\Transport\Common\Transport;
use ServiceBus\Transport\Module\RedisTransportModule;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 *
 */
final class RedisTransportModuleTest extends TestCase
{
    /**
     * @test
     *
     * @throws \Throwable
     *
     * @return void
     *
     */
    public function boot(): void
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions(['service_bus.logger' => new Definition(NullLogger::class)]);

        $module = new RedisTransportModule(
            (string) \getenv('REDIS_CONNECTION_DSN'),
            'testChannel'
        );

        $module->boot($containerBuilder);

        $containerBuilder->getDefinition(Transport::class)->setPublic(true);

        $containerBuilder->compile();

        $containerBuilder->get(Transport::class);

        static::assertTrue(true);
    }
}
