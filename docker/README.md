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

## Build the latest images

### ghcr

```shell script
docker build --pull --tag ghcr.io/tommyheavenly7/wp5-host/php-cli:7.4 ./docker/php-cli/
```

```shell script
docker build --pull --tag ghcr.io/tommyheavenly7/wp5-host/php-fpm:7.4 ./docker/php/
```

### docker hub

```shell script
docker build --pull --tag tommynovember7/wp5-host:7.4-cli ./docker/php-cli/
```

```shell script
docker build --pull --tag tommynovember7/wp5-host:7.4-fpm ./docker/php/
```

```shell script
docker build --pull --tag tommynovember7/wp5-host:latest ./docker/php-cli/
```

```shell script
docker build --pull --tag tommynovember7/wp5-host:latest-fpm ./docker/php/
```

## Push the images

### ghcr

```shell script
docker push ghcr.io/tommyheavenly7/wp5-host/php-cli:7.4
```

```shell script
docker push ghcr.io/tommyheavenly7/wp5-host/php-fpm:7.4
```

### docker hub

```shell script
docker push tommynovember7/wp5-host:7.4-cli
```

```shell script
docker push tommynovember7/wp5-host:7.4-fpm
```

```shell script
docker push tommynovember7/wp5-host:latest
```

```shell script
docker push tommynovember7/wp5-host:latest-fpm
```
