<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\ConnectionIterator;
use ICanBoogie\HTTP\Headers\ServerTiming;
use ICanBoogie\ServerTimingProvider;

/**
 * Adds the `db` metric, the time spent executing queries on the established connections.
 *
 * Connections that are not established are skipped, so the provider never opens one.
 */
final readonly class ActiveRecordServerTimingProvider implements ServerTimingProvider
{
    public function __construct(
        private ConnectionIterator $connections,
    ) {
    }

    #[\Override]
    public function alter(ServerTiming $timing): void
    {
        $duration = 0.0;
        $count = 0;

        foreach ($this->connections->connection_iterator() as $accessor) {
            if (!$accessor->instantiated) {
                continue;
            }

            // Queries of one connection don't overlap, so durations are summed.
            foreach ($accessor->get()->telemetry->record_execute_time as $record) {
                $duration += $record->duration;
                $count++;
            }
        }

        if (!$count) {
            return;
        }

        $timing->add('db', $duration * 1000, "$count queries");
    }
}
