# Migration

## v5.x to v6.0

### New Requirements

None

### New features

- Added a `ConfigBuild`, to follow ICanBoogie/Config changes.
- Added the console commands `activerecord:connections:list` and `activerecord:models:list`, with aliases `activerecord:connections` and `activerecord:models` respectively.
- Configures `StaticModelResolver`.

### Backward Incompatible Changes

- Removed `Application` prototypes: `get_connections`, `get_models`, and `get_db`.
- Config synthesizers have been removed in favor of config builders.
- Models must define their ActiveRecord class, and it must extend `ActiveRecord`.

### Deprecated Features

None

### Other Changes

- `Config`, `ConnectionProvider`, and `ModelProvider` are now created by the dependency-injection container.
