# technicalTest
## With docker

### To init the project (database + schemas + datas), please run 
`php bin/console  init-project`

## Without docker
### Install 
* `composer install` 
### To init the project (database + schemas + datas), please run 
`docker exec -ti sf-console php bin/console init-project`

##### Availables routes are
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
