# Binding ActiveRecord to ICanBoogie

[![Release](https://img.shields.io/github/release/ICanBoogie/bind-activerecord.svg)](https://github.com/ICanBoogie/bind-activerecord/releases)
[![Build Status](https://img.shields.io/travis/ICanBoogie/bind-activerecord.svg)](http://travis-ci.org/ICanBoogie/bind-activerecord)
[![HHVM](https://img.shields.io/hhvm/icanboogie/bind-activerecord.svg)](http://hhvm.h4cc.de/package/icanboogie/bind-activerecord)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/bind-activerecord.svg)](https://scrutinizer-ci.com/g/ICanBoogie/bind-activerecord)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/bind-activerecord.svg)](https://coveralls.io/r/ICanBoogie/bind-activerecord)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/bind-activerecord.svg)](https://packagist.org/packages/icanboogie/bind-activerecord)

The **icanboogie/bind-activerecord** package binds the [ActiveRecord package][] to [ICanBoogie][].





## Autoconfig

The package supports the _autoconfig_ feature of the framework [ICanBoogie][] and provides
the following:

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





### The `activerecord` config

Currently `activerecord` fragments are used synthesize `activerecord_connections` and
`activerecord_models` config, suitable to create [ConnectionCollection][] and
[ModelCollection][] instances.

The following example demonstrates how to define connections and models. Two connections
are defined, `primary` is a connection to the MySQL server and `cache` is a connection to a SQLite
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
			
				ConnectionOptions:TIMEZONE => '+02.00',
				ConnectionOptions::TABLE_NAME_PREFIX => 'myprefix'
			
			]
		],

		'cache' => [

			'dsn' => 'sqlite:' . ICanBoogie\REPOSITORY . 'cache.sqlite'

		]
	],
	
	'models' => [
	
		'nodes' => [
		
			Model::SCHEMA => [
			
				'fields' => [
				
					'id' => 'serial',
					'title' => 'varchar'
				
				]
			]
		]
	]
];
```





----------





## Requirements

The package requires PHP 5.6 or later.





## Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/):

```
$ composer require icanboogie/bind-activerecord
```





### Cloning the repository

The package is [available on GitHub](https://github.com/ICanBoogie/bind-activerecord), its repository
can be cloned with the following command line:

	$ git clone https://github.com/ICanBoogie/bind-activerecord.git





## Testing

The test suite is ran with the `make test` command. [Composer](http://getcomposer.org/) is
automatically installed as well as all dependencies required to run the suite. You can later
clean the directory with the `make clean` command.

The package is continuously tested by [Travis CI](http://about.travis-ci.org/).

[![Build Status](https://img.shields.io/travis/ICanBoogie/bind-activerecord.svg)](https://travis-ci.org/ICanBoogie/bind-activerecord)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/bind-activerecord.svg)](https://coveralls.io/r/ICanBoogie/bind-activerecord)





## Documentation

The package is documented as part of the [ICanBoogie](http://icanboogie.org/) framework
[documentation](http://icanboogie.org/docs/). You can generate the documentation for the package
and its dependencies with the `make doc` command. The documentation is generated in the `docs`
directory. [ApiGen](http://apigen.org/) is required. You can later clean the directory with
the `make clean` command.





## License

ICanBoogie/ActiveRecord is licensed under the New BSD License - See the [LICENSE](LICENSE) file for details.





[ActiveRecord package]: https://github.com/ICanBoogie/ActiveRecord
[ConnectionCollection]: http://icanboogie.org/docs/class-ICanBoogie.ActiveRecord.ConnectionCollection.html
[ICanBoogie]: https://github.com/ICanBoogie/ICanBoogie
[ModelCollection]: http://icanboogie.org/docs/class-ICanBoogie.ActiveRecord.ModelCollection.html
