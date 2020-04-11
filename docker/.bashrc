export PATH="./docker/bin:../docker/bin:../../docker/bin:$PATH"

_exec() {
  [[ -z "$2" ]] && docker exec -it "$1" bash \
  || docker exec -it "$1" "$2"
}
alias _build="docker-compose build --force-rm --pull"
alias _ps="docker-compose ps"
alias _run="docker-compose run --rm"
alias _stop="docker-compose stop"
alias _up="docker-compose up --detach --force-recreate --remove-orphans"
alias no-start="docker-compose up --no-start --force-recreate --remove-orphans"
alias hadolint="docker-compose run --rm hadolint"
alias php="docker-compose run --rm php-cli"
alias composer="docker-compose run --rm composer"
alias git="docker-compose run --rm git"