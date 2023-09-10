# bind-activerecord

[![Packagist](https://img.shields.io/packagist/v/icanboogie/bind-activerecord.svg)](https://packagist.org/packages/icanboogie/bind-activerecord)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/bind-activerecord.svg)](https://scrutinizer-ci.com/g/ICanBoogie/bind-activerecord)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/bind-activerecord.svg)](https://coveralls.io/r/ICanBoogie/bind-activerecord)
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

```bash
composer require icanboogie/bind-activerecord
```



## Autoconfig

The package provides a configuration builder for `ICanBoogie\ActiveRecord\Config`.



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
use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\ConfigBuilder;
use ICanBoogie\ActiveRecord\SchemaBuilder;

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
        activerecord_class: Node::class,
        schema_builder: fn(SchemaBuilder $b) => $b
            ->add_serial('id',primary: true)
            ->add_varchar('title')
    );
```



----------



## Continuous Integration

The project is continuously tested by [GitHub actions](https://github.com/ICanBoogie/bind-activerecord/actions).

[![Tests](https://github.com/ICanBoogie/activerecord/workflows/test/badge.svg?branch=master)](https://github.com/ICanBoogie/activerecord/actions?query=workflow%3Atest)
[![Static Analysis](https://github.com/ICanBoogie/activerecord/workflows/static-analysis/badge.svg?branch=master)](https://github.com/ICanBoogie/ActiveRecord/actions?query=workflow%3Astatic-analysis)
[![Code Style](https://github.com/ICanBoogie/activerecord/workflows/code-style/badge.svg?branch=master)](https://github.com/ICanBoogie/activerecord/actions?query=workflow%3Acode-style)



## Code of Conduct

This project adheres to a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in
this project and its community, you are expected to uphold this code.



## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.



## License

**icanboogie/bind-activerecord** is released under the [BSD-3-Clause](LICENSE).






[ICanBoogie]: https://icanboogie.org/
[documentation]:           https://icanboogie.org/api/bind-activerecord/master/
[ConnectionCollection]:    https://icanboogie.org/api/activerecord/master/class-ICanBoogie.ActiveRecord.ConnectionCollection.html
[ModelCollection]:         https://icanboogie.org/api/activerecord/master/class-ICanBoogie.ActiveRecord.ModelCollection.html
[icanboogie/activerecord]: https://github.com/ICanBoogie/ActiveRecord
