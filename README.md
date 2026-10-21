# bind-activerecord

[![Release](https://img.shields.io/packagist/v/icanboogie/bind-activerecord.svg)](https://packagist.org/packages/icanboogie/bind-activerecord)
[![Code Coverage](https://coveralls.io/repos/github/ICanBoogie/bind-activerecord/badge.svg?branch=7.0)](https://coveralls.io/r/ICanBoogie/bind-activerecord?branch=7.0)
[![Downloads](https://img.shields.io/packagist/dt/icanboogie/bind-activerecord.svg)](https://packagist.org/packages/icanboogie/bind-activerecord)

The **icanboogie/bind-activerecord** package binds the [icanboogie/activerecord][] package to
[ICanBoogie][], using its _Autoconfig_ feature. It provides configuration builders for active record
connections and models, as well as getters for the connection provider and the model provider.

```php
<?php
namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\Application;
use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\ConnectionProvider;
use ICanBoogie\ActiveRecord\ModelProvider;

/* @var Application $app */

$app = boot();

$config = $app->configs[Config::class];

echo count($config->connections);
echo count($config->models);

$primary_connection = $app->service_for_id('active_record.connection.primary', Connection::class);
# or
$primary_connection = $app->service_for_class(ConnectionProvider::class)->connection_for_id('primary');

$nodes = $app->service_for_class(ModelProvider::class)->model_for_record(Node::class);
```



#### Installation

```shell
composer require icanboogie/bind-activerecord
```



## Autoconfig

The package provides a configuration builder for `ICanBoogie\ActiveRecord\Config`.



### The `activerecord` config fragment

Currently `activerecord` fragments are used to configure connections and models, which are suitable
to create [ConnectionRegistry][] and [ModelRegistry][] instances.

The following example demonstrates how to define connections and models. Two connections are
defined: `primary` is a connection to the MySQL server;`cache` is a connection to a SQLite database.
The `nodes` model is also defined.

```php
<?php

// config/activerecord.php

use ICanBoogie\ActiveRecord\ConnectionOptions;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\Schema;
use ICanBoogie\ActiveRecord\SchemaColumn;
use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\ConfigBuilder;
use ICanBoogie\ActiveRecord\SchemaBuilder;
use ICanBoogie\Env;

return fn(ConfigBuilder $config) => $config
    ->enable_discovery()
    ->add_connection(
        id: Config::DEFAULT_CONNECTION_ID,
        dsn: Env::string('APP_DATABASE_DSN'),
        username: Env::string('APP_DATABASE_USERNAME'),
        password: Env::string('APP_DATABASE_PASSWORD'),
        table_name_prefix: 'myprefix',
        time_zone: '+02:00',
    )
    ->add_connection(
        id: 'cache',
        dsn: 'sqlite:var/cache.sqlite'
    )
    ->add_record(Node::class)
;
```



## Server-Timing

Installing the package registers `ActiveRecordServerTimingProvider` with the
`server_timing_providers` option of the application. Once the application calls
`enable_server_timing()` on its `AppConfigBuilder`, the response gets a `db` metric:

```
Server-Timing: db;dur=12.3;desc="7 queries"
```

`dur` is the sum of the time spent executing queries, in milliseconds, on the connections that are
established. Connections that are not are skipped, the provider never opens one, and nothing is
added when no query was executed.

The header exposes internals to every client, enable it for development and staging only. To drop
the metric, call `remove_server_timing_provider(ActiveRecordServerTimingProvider::class)` in the
`app` config of the application.



----------



## Continuous Integration

The project is continuously tested by [GitHub Actions](https://github.com/ICanBoogie/bind-activerecord/actions).

[![Tests](https://github.com/ICanBoogie/bind-activerecord/actions/workflows/test.yml/badge.svg?branch=7.0)](https://github.com/ICanBoogie/bind-activerecord/actions/workflows/test.yml)
[![Static Analysis](https://github.com/ICanBoogie/bind-activerecord/actions/workflows/static-analysis.yml/badge.svg?branch=7.0)](https://github.com/ICanBoogie/bind-activerecord/actions/workflows/static-analysis.yml)
[![Code Style](https://github.com/ICanBoogie/bind-activerecord/actions/workflows/code-style.yml/badge.svg?branch=7.0)](https://github.com/ICanBoogie/bind-activerecord/actions/workflows/code-style.yml)



## Code of Conduct

This project adheres to a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in
this project and its community, you're expected to uphold this code.



## Contributing

See [CONTRIBUTING](CONTRIBUTING.md) for details.



[ICanBoogie]: https://icanboogie.org/
[documentation]:           https://icanboogie.org/api/bind-activerecord/master/
[ConnectionRegistry]:      https://icanboogie.org/api/activerecord/master/class-ICanBoogie.ActiveRecord.ConnectionRegistry.html
[ModelRegistry]:           https://icanboogie.org/api/activerecord/master/class-ICanBoogie.ActiveRecord.ModelRegistry.html
[icanboogie/activerecord]: https://github.com/ICanBoogie/ActiveRecord
