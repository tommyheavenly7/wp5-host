# How to login github docker repo

## Log in the package repo

Before pushing the latest build, you need to log in `ghcr.io`. 
In case if you don't have the personal access token, you must generate 
it to log in the repo.

### ghcr

```shell script
echo $PACKAGE_TOKEN | docker login ghcr.io -u $USER_NAME --password-stdin
```

### docker hub

```shell script
echo $DOCKER_TOKEN | docker login -u $DOCKER_USER_NAME --password-stdin
```

## Build and push the latest images

Firstly, you might want to enable `buildx` to build for multiple platforms at a time:

```shell script
docker buildx create --use
```

```text
$ docker buildx --help

Usage:  docker buildx [OPTIONS] COMMAND

Extended build capabilities with BuildKit

Options:
      --builder string   Override the configured builder instance

Management Commands:
  imagetools  Commands to work on images in registry

Commands:
  bake        Build from a file
  build       Start a build
  create      Create a new builder instance
  du          Disk usage
  inspect     Inspect current builder instance
  ls          List builder instances
  prune       Remove build cache
  rm          Remove a builder instance
  stop        Stop builder instance
  use         Set the current builder instance
  version     Show buildx version information

Run 'docker buildx COMMAND --help' for more information on a command.
```

### ghcr

```shell script
docker buildx build --platform linux/amd64,linux/arm64 --pull --no-cache --push --tag ghcr.io/tommyheavenly7/wp5-host/php-cli:7.4 ./docker/php-cli/
```

```shell script
docker buildx build --platform linux/amd64,linux/arm64 --pull --no-cache --push --tag ghcr.io/tommyheavenly7/wp5-host/php-fpm:7.4 ./docker/php/
```

### docker hub

```shell script
docker buildx build --platform linux/amd64,linux/arm64 --pull --no-cache --push --tag tommynovember7/wp5-host:7.4-cli ./docker/php-cli/
```

```shell script
docker buildx build --platform linux/amd64,linux/arm64 --pull --no-cache --push --tag tommynovember7/wp5-host:7.4-fpm ./docker/php/
```

```shell script
docker buildx build --platform linux/amd64,linux/arm64 --pull --push --tag tommynovember7/wp5-host:latest ./docker/php-cli/
```

```shell script
docker buildx build --platform linux/amd64,linux/arm64 --pull --push --tag tommynovember7/wp5-host:latest-fpm ./docker/php/
```
