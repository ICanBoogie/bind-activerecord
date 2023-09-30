# Migration

## v5.x to v6.0

### New Requirements

- PHP 8.1+

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
