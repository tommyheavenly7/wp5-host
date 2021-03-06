# How to login github docker repo

## Log in the package repo

Before pushing the latest build, you need to log in `docker.pkg.github.com`. 
In case if you don't have the personal access token, you must generate 
it to log in the repo.

```shell script
echo $PACKAGE_TOKEN | docker login docker.pkg.github.com -u $USER_NAME --password-stdin
```

## Build the latest images

```shell script
docker build --pull --tag docker.pkg.github.com/tommyheavenly7/wp5-host/php-cli:7.4 ./docker/php-cli/
docker build --pull --tag docker.pkg.github.com/tommyheavenly7/wp5-host/php-fpm:7.4 ./docker/php/
```

## Push the images

```shell script
docker push docker.pkg.github.com/tommyheavenly7/wp5-host/php-cli:7.4
docker push docker.pkg.github.com/tommyheavenly7/wp5-host/php-fpm:7.4
```