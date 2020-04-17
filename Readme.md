# TechnicalTest
## Without docker

### To init the project (database + schemas + datas), please run 
`php bin/console  init-project` 
*  run the project 
 > symfony server:start

Access to the page web with: https://127.0.0.1:8000 
### Unit tests 
 > vendor/bin/simple-phpunit

## Without docker
### Install  
* setting database params under ./env and under config/packages/doctrine.yaml
*  > `docker exec -ti sf-console php bin/console init-project`

 Access to the page web with: https://127.0.0.1:8888

### Unit tests 
*  > ` docker exec -ti sf-console vendor/bin/simple-phpunit`
 
## Availables routes are:
 - /answer/list
 - /answer/new
 - /answer/{id}
 - /answer/{id}/edit
 - /answer/{id}
 - /api/question/put
 - /question/list
 - /question/new
 - /question/{id}
 - /question/{id}/edit
 - /question/{id}
 - /
