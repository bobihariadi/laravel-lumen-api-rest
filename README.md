

# Lumen (8.0.1) (Laravel Components ^8.0)

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## REST API Using BASIC AUTH, API KEY and Bearer(JWT) Authentication

A sample of REST API using some authentication

## Installation
```bash
composer global require "laravel/lumen-installer"
```


```bash
git clone https://github.com/bobihariadi/laravel-lumen-api-rest.git
```

go to folder and run this command, make sure you have composer intalled on your computer
```bash
composer install
```


Rename .env.example to .env



Create databse MySQL with name "dblumen" (charset "utf8", collation "utf8_unicode_ci")  and then run this command

```bash
php artisan migrate
```

## Run aplication
```bash
php -S localhost:8000 -t public/
```

## Test API on POSTMAN
### Create new user (no auth required)
- Creaate a new service REST
- use "POST" method
- use url "http://localhost:8000/api/v1/users/add"
- Add Headers tab with Key "Content-Type" and Value "application/json"
- Tab Body fill with bellow
```json
{
    "name"      : "Bobi Hariadi",
    "email"     : "bobihariadi@gmail.com",
    "password"  : "pass123abc"
}
```
- Click Send

Copy api_token code.

### Show data user (basic auth)
- Creatae a new service REST
- use "GET" method
- use url "http://localhost:8000/api/v1/users/index"
- Tab Authorization change with Basic Auth
- Username fill with "bobihariadi@gmail.com"
- Password fill with api_token you have copied
- Click Send


### Create data posts
- Create a new service REST
- use "POST" method
- use url "http://localhost:8000/api/v1/posts/add"
- Add Headers tab with Key "Content-Type" and Value "application/json"
- Tab Body fill with bellow
```json
{
    "title" : "sample title",
    "body"  : "sample body",
    "views" : "1"
}
```
- Click Send


### Show data post (Api Key)
- Creatae a new service REST
- use "GET" method
- use url "http://localhost:8000/api/v1/posts/index"
- Tab Authorization change with Api Key
- Key fill with "api_key"
- Value fill with api_token you have copied
- Click Send


### Show data post (Bearer Token)
- Creatae a new service REST
- use "POST" method
- use url "http://localhost:8000/api/v1/users/sampleJwt"
- Tab Authorization change with Bearer Token
- Token fill with jwt_token you have copied
- Click Send



## Globals Parameter IndexController and StoreController

Documentation for globally "body" parameter which make API be simple

### IndexController

Method  : POST
Auth    : Bearer Token
Header  : Content-Type | Application/json
Body    : raw
Url     : http://localhost:8000/api/v1/store 


#### Basic
```json
{
	"action"    :"index",
	"db"        :"mysql",
	"table"     :"posts"
}
```

#### Selected field
```json
    "selected":[
            "field","other field","other field"
    ]
```

### About me

https://bobihariadi.github.io/my-profile/



## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
