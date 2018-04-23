# Setup
docker ps

docker exec -it {container id} bash

php web/bootstrap.php

# TEST
docker ps

docker exec -it {container id} bash

vendor/bin/phpunit tests

# Api Endpoint

## /token
Method = POST

#### Request Body
```php
  {	
    "email": "test@hellofresh.com",
    "password":"hellofresh"
  }
```

#### Response
```php
{
    "status_code": 200,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIiwianRpIjoiNGYxZzIzYTEyYWEifQ.eyJpc3MiOiJIZWxsb2ZyZXNoIiwiYXVkIjoiSGVsbG9mcmVzaCIsImp0aSI6IjRmMWcyM2ExMmFhIiwiaWF0IjoxNTIzOTM0NDEzLCJuYmYiOjE1MjM5MzQ0MTMsImV4cCI6MTUyMzkzODAxMywidXNlcl9lbWFpbCI6InRlc3RAaGVsbG9mcmVzaC5jb20ifQ."
}
```

## /recipes
Method = GET

#### Request Body
empty
#### Response
```php
"current_page": 1,
"data": [
  {
    "id": 2,
    "user_id": null,
    "name": "vegan",
    "prepare_time": 10,
    "difficulty": 1,
    "vegetarian": true,
    "created_at": "2018-04-14 11:03:36",
    "updated_at": "2018-04-14 11:03:36",
    "ratings": [
      {
        "id": 7,
        "recipe_id": 2,
        "user_id": null,
        "stars": 5,
        "created_at": "2018-04-15 18:05:29",
        "updated_at": "2018-04-15 18:05:29"
      },
    ]
  }
],
"first_page_url": "/?page=1",
"from": 1,
"last_page": 2,
"last_page_url": "/?page=2",
"next_page_url": "/?page=2",
"path": "/",
"per_page": 20,
"prev_page_url": null,
"to": 20,
"total": 21
```

## /recipes
Method = POST
#### Request Header
```php
[
  {"key":"Content-Type","value":"application/json"},
  {"key":"Accept","value":"application/json"},
  {"key":"Authorization","value":"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIiwianRpIjoiNGYxZzIzYTEyYWEifQ.eyJpc3MiOiJIZWxsb2ZyZXNoIiwiYXVkIjoiSGVsbG9mcmVzaCIsImp0aSI6IjRmMWcyM2ExMmFhIiwiaWF0IjoxNTIzOTM0NDEzLCJuYmYiOjE1MjM5MzQ0MTMsImV4cCI6MTUyMzkzODAxMywidXNlcl9lbWFpbCI6InRlc3RAaGVsbG9mcmVzaC5jb20ifQ."}
]
```

#### Request Body
{
    "name": "vegan",
    "difficulty": 1,
    "vegetarian" : true,
    "prepare_time" : 10
}

#### Response
```php
{
    "status": "success",
    "data": {
        "name": "vegan",
        "difficulty": 1,
        "vegetarian": true,
        "prepare_time": 10,
        "updated_at": "2018-04-17 03:28:27",
        "created_at": "2018-04-17 03:28:27",
        "id": 28
    }
}
```

#### Validation Error
```php
{
    "reason_phrase": "Validation error",
    "status_code": 422,
    "errors": {
        "difficulty": [
            "The difficulty must be between 1 and 3."
        ],
        "vegetarian": [
            "The vegetarian must be boolean."
        ]
    }
}
```

## /recipes/2
Method = GET

#### Request Body
empty
#### Response
```php
"data": {
  "id": 2,
  "user_id": null,
  "name": "vegan",
  "prepare_time": 10,
  "difficulty": 1,
  "vegetarian": true,
  "created_at": "2018-04-14 11:03:36",
  "updated_at": "2018-04-14 11:03:36"
}
```

## /recipes/2
Method = PATCH
#### Request Header
```php
[
  {"key":"Content-Type","value":"application/json"},
  {"key":"Accept","value":"application/json"},
  {"key":"Authorization","value":"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIiwianRpIjoiNGYxZzIzYTEyYWEifQ.eyJpc3MiOiJIZWxsb2ZyZXNoIiwiYXVkIjoiSGVsbG9mcmVzaCIsImp0aSI6IjRmMWcyM2ExMmFhIiwiaWF0IjoxNTIzOTM0NDEzLCJuYmYiOjE1MjM5MzQ0MTMsImV4cCI6MTUyMzkzODAxMywidXNlcl9lbWFpbCI6InRlc3RAaGVsbG9mcmVzaC5jb20ifQ."}
]
```

#### Request Body
{
    "name": "vegan",
    "difficulty": 2,
    "vegetarian" : true,
    "prepare_time" : 10
}

#### Response
```php
{
    "status": "success",
    "data": {
        "name": "vegan",
        "difficulty": 2,
        "vegetarian": true,
        "prepare_time": 10,
        "updated_at": "2018-04-17 03:28:27",
        "created_at": "2018-04-17 03:28:27",
        "id": 28
    }
}
```

#### Validation Error
```php
{
    "reason_phrase": "Validation error",
    "status_code": 422,
    "errors": {
        "difficulty": [
            "The difficulty must be between 1 and 3."
        ],
        "vegetarian": [
            "The vegetarian must be boolean."
        ]
    }
}
```

## /recipes/2
Method = DELETE
#### Request Header
```php
[
  {"key":"Content-Type","value":"application/json"},
  {"key":"Accept","value":"application/json"},
  {"key":"Authorization","value":"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIiwianRpIjoiNGYxZzIzYTEyYWEifQ.eyJpc3MiOiJIZWxsb2ZyZXNoIiwiYXVkIjoiSGVsbG9mcmVzaCIsImp0aSI6IjRmMWcyM2ExMmFhIiwiaWF0IjoxNTIzOTM0NDEzLCJuYmYiOjE1MjM5MzQ0MTMsImV4cCI6MTUyMzkzODAxMywidXNlcl9lbWFpbCI6InRlc3RAaGVsbG9mcmVzaC5jb20ifQ."}
]
```

#### Request Body
empty

#### Response
```php
{
    "status": "success"
}
```

## /recipes/2/rating
Method = POST
#### Request Header
```php
[
  {"key":"Content-Type","value":"application/json"},
  {"key":"Accept","value":"application/json"},
  {"key":"Authorization","value":"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIiwianRpIjoiNGYxZzIzYTEyYWEifQ.eyJpc3MiOiJIZWxsb2ZyZXNoIiwiYXVkIjoiSGVsbG9mcmVzaCIsImp0aSI6IjRmMWcyM2ExMmFhIiwiaWF0IjoxNTIzOTM0NDEzLCJuYmYiOjE1MjM5MzQ0MTMsImV4cCI6MTUyMzkzODAxMywidXNlcl9lbWFpbCI6InRlc3RAaGVsbG9mcmVzaC5jb20ifQ."}
]
```

#### Request Body
{	
	"stars":5
}

#### Response
```php
{
    "status": "success",
    "recipe": {
        "id": 2,
        "user_id": null,
        "name": "vegan",
        "prepare_time": 10,
        "difficulty": 1,
        "vegetarian": true,
        "created_at": "2018-04-14 11:03:36",
        "updated_at": "2018-04-14 11:03:36",
        "ratings": [
            {
                "id": 6,
                "recipe_id": 2,
                "user_id": 1,
                "stars": 5,
                "created_at": "2018-04-15 18:03:33",
                "updated_at": "2018-04-15 18:03:33"
            },
        ]
    }
}
```

#### Validation Error
```php
{
    "reason_phrase": "Validation error",
    "status_code": 422,
    "errors": {
        "difficulty": [
            "The stars must be between 1 and 5."
        ]
    }
}
```

