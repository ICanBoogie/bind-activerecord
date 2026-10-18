<?php

namespace Test\ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Config\ConnectionDefinition;
use ICanBoogie\ActiveRecord\ConnectionRegistry;
use ICanBoogie\AppConfig;
use ICanBoogie\Binding\ActiveRecord\ActiveRecordServerTimingProvider;
use ICanBoogie\HTTP\Headers\ServerTiming;
use PHPUnit\Framework\TestCase;

use function ICanBoogie\app;

final class ActiveRecordServerTimingProviderTest extends TestCase
{
    private ConnectionRegistry $connections;

    protected function setUp(): void
    {
        $this->connections = new ConnectionRegistry([
            new ConnectionDefinition('a', 'sqlite::memory:'),
            new ConnectionDefinition('b', 'sqlite::memory:'),
            new ConnectionDefinition('c', 'sqlite::memory:'),
        ]);
    }

    public function test_provider_is_registered_by_the_package(): void
    {
        $config = app()->config_for_class(AppConfig::class);

        $this->assertContains(ActiveRecordServerTimingProvider::class, $config->server_timing_providers);
    }

    public function test_provider_is_a_public_service(): void
    {
        $actual = app()->service_for_class(ActiveRecordServerTimingProvider::class);

        $this->assertInstanceOf(ActiveRecordServerTimingProvider::class, $actual);
    }

    public function test_adds_nothing_without_queries(): void
    {
        $this->connections->connection_for_id('a');
        $timing = new ServerTiming();

        new ActiveRecordServerTimingProvider($this->connections)->alter($timing);

        $this->assertSame([], $timing->metrics);
    }

    public function test_sums_queries_of_established_connections(): void
    {
        $a = $this->connections->connection_for_id('a');
        $a->exec('CREATE TABLE t (id INTEGER)');
        $a->exec('INSERT INTO t VALUES (1)');
        $this->connections->connection_for_id('b')->exec('CREATE TABLE t (id INTEGER)');
        $timing = new ServerTiming();

        new ActiveRecordServerTimingProvider($this->connections)->alter($timing);

        $this->assertCount(1, $timing->metrics);
        $metric = $timing->metrics[0];
        $this->assertSame('db', $metric->name);
        $this->assertSame('3 queries', $metric->description);
        $expected = 0.0;

        foreach ([ $a, $this->connections->connection_for_id('b') ] as $connection) {
            foreach ($connection->telemetry->record_execute_time as $record) {
                $expected += $record->duration * 1000;
            }
        }

        $this->assertNotNull($metric->duration);
        $this->assertEqualsWithDelta($expected, $metric->duration, 1e-9);
    }

    public function test_does_not_establish_connections(): void
    {
        $this->connections->connection_for_id('a')->exec('CREATE TABLE t (id INTEGER)');

        new ActiveRecordServerTimingProvider($this->connections)->alter(new ServerTiming());

        $actual = [];

        foreach ($this->connections->connection_iterator() as $id => $accessor) {
            $actual[$id] = $accessor->instantiated;
        }

        $this->assertSame([ 'a' => true, 'b' => false, 'c' => false ], $actual);
    }
}
