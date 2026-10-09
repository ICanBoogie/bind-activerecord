# Migration

## v7.0.0

### New Requirements

- PHP 8.4+

### New features

- Added `AutowireModel` to replace `Record`.
- Added the `ICanBoogie\ActiveRecord\ModelInstaller` service.
- `activerecord:install` installs the models with `ModelInstaller`, after their parent and the
  tables referenced by their foreign keys. The rows follow the install order, and the models that
  depend on a model that failed are reported as "Skipped".

### Backward Incompatible Changes

- Following `icanboogie/activerecord` v7.0, the `ICanBoogie\ActiveRecord\ModelCollection` service
  is renamed as `ICanBoogie\ActiveRecord\ModelRegistry`, and the `ConnectionProvider` service is a
  `ConnectionRegistry` instead of a `ConnectionCollection`. Better depend on the `ModelProvider` and
  `ConnectionProvider` interfaces.
- `InstallCommand` takes a `ModelInstaller` instead of a `ModelProvider` and a `ModelIterator`.

### Deprecated Features

- `Record` is deprecated; use `AutowireModel` instead.

### Other Changes

None



## v5.x to v6.0

### New Requirements

- PHP 8.2+

### New features

- Added a `ConfigBuilder`, to follow ICanBoogie/Config changes. Use ActiveRecord's `ConfigBuilder`.
- Added the console commands `activerecord:connections` and `activerecord:records` (alias `activerecords`).
- Configures `StaticModelResolver`.

### Backward Incompatible Changes

- Removed `Application` prototypes: `get_connections`, `get_models`, and `get_db`.
- Config synthesizers have been removed in favor of config builders.
- Models must define their ActiveRecord class, and it must extend `ActiveRecord`.

### Deprecated Features

None

### Other Changes

- `Config`, `ConnectionProvider`, and `ModelProvider` are now created by the dependency-injection container.
