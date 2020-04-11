# wp5-host

## Build Dockerfiles

```bash
## build all
$ docker/bin/build-dockerfiles.sh

## build only php
$ docker/bin/build-dockerfiles.sh php
```

## Build containers using `docker-compose`

Before running tests, you should build containers:

```bash
source docker/.bashrc
_build
```

## Running tests

### Redis connection test

```bash
composer run redis-test
```

### MySQL connection test

```bash
composer run mysql-test
```

### Email function test

The following script sends an email, but `MailCatcher` will capture it.
You can see the mail at [localhost:1080](http://localhost:1080/)

```bash
php project/send-email.php
```
