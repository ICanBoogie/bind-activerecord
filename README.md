# bind-activerecord

[![Release](https://img.shields.io/packagist/v/ICanBoogie/bind-activerecord.svg)](https://packagist.org/packages/icanboogie/bind-activerecord)
[![Build Status](https://img.shields.io/github/workflow/status/ICanBoogie/bind-activerecord/test)](https://github.com/ICanBoogie/bind-activerecord/actions?query=workflow%3Atest)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/bind-activerecord.svg)](https://scrutinizer-ci.com/g/ICanBoogie/bind-activerecord)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/bind-activerecord.svg)](https://coveralls.io/r/ICanBoogie/bind-activerecord)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/bind-activerecord.svg)](https://packagist.org/packages/icanboogie/bind-activerecord)

The **icanboogie/bind-activerecord** package binds the [icanboogie/activerecord][] package to
[ICanBoogie][], using its _Autoconfig_ feature. It provides configuration builders for active record
connections and models, as well as getters for the connection provider and the model provider.

```php
<?php
namespace ICanBoogie\Binding\ActiveRecord;

$app = boot();

$config = $app->configs[Config::KEY];

echo count($config->connections);
echo count($config->models);

echo get_class($app->connections);               // ICanBoogie\ActiveRecord\ConnectionProvider
echo get_class($app->models);                    // ICanBoogie\ActiveRecord\ModelProvider

$primary_connection = $app->connections->connection_for_id('primary');
$primary_connection === $app->db;                // true

get_models('nodes') === $app->models->model_for_id('nodes');   // true
```



#### Installation

```bash
composer require icanboogie/bind-activerecord
```



## Autoconfig

[ICanBoogie][]'s _Autoconfig_ is used to provide the following features:

- A config builder for the `activerecord` config, created from the `activerecord` fragments.
- A synthesizer for the `activerecord_models` config, created from the `activerecord#models`
  fragments.
- A lazy getter for the `ICanBoogie\Application::$connections` property, that returns
a `ConnectionProvider`.
- A lazy getter for the `ICanBoogie\Application::$models` property, that returns
a `ModelProvider`.
- A lazy getter for the `ICanBoogie\Application::$db` property, that returns the connection named
`primary` from the `ICanBoogie\Application::$connections` property.





### The `activerecord` config fragment

Currently `activerecord` fragments are used to configure connections and models, which are suitable
to create [ConnectionCollection][] and [ModelCollection][] instances.

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
use ICanBoogie\Binding\ActiveRecord\Config;
use ICanBoogie\Binding\ActiveRecord\ConfigBuilder;

return fn(ConfigBuilder $config) => $config
    ->add_connection(
        id: Config::DEFAULT_CONNECTION_ID,
        dsn: 'mysql:dbname=mydatabase',
        username: 'root',
        password: 'root',
        table_name_prefix: 'myprefix',
        time_zone: '+02:00',
    )
    ->add_connection(
        id: 'cache',
        dsn: 'sqlite:' . ICanBoogie\REPOSITORY . 'cache.sqlite'
    )
    ->add_model(
        id: 'nodes',
        schema: new Schema([
            'id' => SchemaColumn::serial(primary: true),
            'title' => SchemaColumn::varchar(),
        ])
    );
```



----------



## Testing

Run `make test-container` to create and log into the test container, then run `make test` to run the
test suite. Alternatively, run `make test-coverage` to run the test suite with test coverage. Open
`build/coverage/index.html` to see the breakdown of the code coverage.





## License

**icanboogie/bind-activerecord** is released under the [New BSD License](LICENSE).






[documentation]:           https://icanboogie.org/api/bind-activerecord/master/
[ConnectionCollection]:    https://icanboogie.org/api/activerecord/master/class-ICanBoogie.ActiveRecord.ConnectionCollection.html
[ModelCollection]:         https://icanboogie.org/api/activerecord/master/class-ICanBoogie.ActiveRecord.ModelCollection.html
[icanboogie/activerecord]: https://github.com/ICanBoogie/ActiveRecord
[ICanBoogie]:              https://github.com/ICanBoogie/ICanBoogie
