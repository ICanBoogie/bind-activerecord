# bind-activerecord

[![Release](https://img.shields.io/packagist/v/ICanBoogie/bind-activerecord.svg)](https://packagist.org/packages/icanboogie/bind-activerecord)
[![Build Status](https://img.shields.io/travis/ICanBoogie/bind-activerecord.svg)](http://travis-ci.org/ICanBoogie/bind-activerecord)
[![HHVM](https://img.shields.io/hhvm/icanboogie/bind-activerecord.svg)](http://hhvm.h4cc.de/package/icanboogie/bind-activerecord)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/bind-activerecord.svg)](https://scrutinizer-ci.com/g/ICanBoogie/bind-activerecord)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/bind-activerecord.svg)](https://coveralls.io/r/ICanBoogie/bind-activerecord)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/bind-activerecord.svg)](https://packagist.org/packages/icanboogie/bind-activerecord)

The **icanboogie/bind-activerecord** package binds the [icanboogie/activerecord][] package to
[ICanBoogie][], using its _Autoconfig_ feature. It provides configuration synthesizers for
connections and models, as well as getters for connection collection and model collection.
The `get_model()` helper is also patched to use the model collection bound to the application.

```php
<?php
namespace ICanBoogie;

$app = boot();

$connections_config = $app->configs['activerecord_connections'];
$models_config = $app->configs['activerecord_models'];

echo get_class($app->connections);               // ICanBoogie\ActiveRecord\ConnectionCollection
echo get_class($app->models);                    // ICanBoogie\ActiveRecord\ModelCollection

$primary_connection = $app->connections['primary'];
$primary_connection === $app->db;                // true

get_models('nodes') === $app->models['nodes'];   // true
```





## Autoconfig

[ICanBoogie][]'s _Autoconfig_ is used to provide the following features:

- A synthesizer for the `activerecord_connections` config, created from
the `activerecord#connections` fragments.
- A synthesizer for the `activerecord_models` config, created from
the `activerecord#models` fragments.
- A lazy getter for the `ICanBoogie\Core::$connections` property, that returns
a [ConnectionCollection][] instance created with the `activerecord_connections` config.
- A lazy getter for the `ICanBoogie\Core::$models` property, that returns
a [ModelCollection][] instance created with the `activerecord_models` config.
- A lazy getter for the `ICanBoogie\Core::$db` property, that returns the connection named
`primary` from the `ICanBoogie\Core::$connections` property.





### The `activerecord` config fragment

Currently `activerecord` fragments are used to synthesize `activerecord_connections` and
`activerecord_models` configurations, which are suitable to create [ConnectionCollection][] and
[ModelCollection][] instances.

The following example demonstrates how to define connections and models. Two connections
are defined: `primary` is a connection to the MySQL server;`cache` is a connection to a SQLite
database. The `nodes` model is also defined.

```php
<?php

// config/activerecord.php

use ICanBoogie\ActiveRecord\ConnectionOptions;
use ICanBoogie\ActiveRecord\Model;

return [

	'connections' => [

		'primary' => [

			'dsn' => 'mysql:dbname=mydatabase',
			'username' => 'root',
			'password' => 'root',
			'options' => [

				ConnectionOptions::TIMEZONE => '+02:00',
				ConnectionOptions::TABLE_NAME_PREFIX => 'myprefix'

			]
		],

		'cache' => 'sqlite:' . ICanBoogie\REPOSITORY . 'cache.sqlite'

	],

	'models' => [

		'nodes' => [

			Model::SCHEMA => [

				'id' => 'serial',
				'title' => 'varchar'

			]
		]
	]
];
```





----------





## Requirements

The package requires PHP 5.5 or later.





## Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/):

```
$ composer require icanboogie/bind-activerecord
```





### Cloning the repository

The package is [available on GitHub](https://github.com/ICanBoogie/bind-activerecord), its repository
can be cloned with the following command line:

	$ git clone https://github.com/ICanBoogie/bind-activerecord.git





## Documentation

The package is documented as part of the [ICanBoogie][] framework
[documentation][]. You can generate the documentation for the package and its dependencies with
the `make doc` command. The documentation is generated in the `build/docs` directory.
[ApiGen](http://apigen.org/) is required. The directory can later be cleaned with
the `make clean` command.





## Testing

The test suite is ran with the `make test` command. [PHPUnit](https://phpunit.de/) and [Composer](http://getcomposer.org/) need to be globally available to run the suite. The command installs dependencies as required. The `make test-coverage` command runs test suite and also creates an HTML coverage report in "build/coverage". The directory can later be cleaned with the `make clean` command.

The package is continuously tested by [Travis CI](http://about.travis-ci.org/).

[![Build Status](https://img.shields.io/travis/ICanBoogie/bind-activerecord.svg)](https://travis-ci.org/ICanBoogie/bind-activerecord)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/bind-activerecord.svg)](https://coveralls.io/r/ICanBoogie/bind-activerecord)





## License

**icanboogie/bind-activerecord** is licensed under the New BSD License - See the [LICENSE](LICENSE) file for details.





[documentation]:           http://api.icanboogie.org/bind-activerecord/3.0/
[ConnectionCollection]:    http://api.icanboogie.org/activerecord/3.0/class-ICanBoogie.ActiveRecord.ConnectionCollection.html
[ModelCollection]:         http://api.icanboogie.org/activerecord/3.0/class-ICanBoogie.ActiveRecord.ModelCollection.html
[icanboogie/activerecord]: https://github.com/ICanBoogie/ActiveRecord
[ICanBoogie]:              https://github.com/ICanBoogie/ICanBoogie
