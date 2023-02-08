# Migration

## v5.x to v6.x

### New Requirements

None

### New features

- Added a `ConfigBuild`, to follow ICanBoogie/Config changes.

### Backward Incompatible Changes

- Removed `Application` prototypes: `get_connections`, `get_models`, and `get_db`.
- Config synthesizers have been removed in favor of config builders.

### Deprecated Features

None

### Other Changes

- `Config`, `ConnectionProvider`, and `ModelProvider` are now created by the DIC.
