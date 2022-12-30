# Lumen test task

## TASK: 
Create RESTFull API.

Description:
Create the API to share the company's information for the logged users.
Please use the Repository-Service pattern in your task.

Details:
Create DB migrations for the tables: users, companies, etc.
Suggest the DB structure. Fill the DB with the test data.

Endpoints:
- https://domain.com/api/user/register
  — method POST
  — fields: first_name [string], last_name [string], email [string], password [string], phone [string]

- https://domain.com/api/user/sign-in
  — method POST
  — fields: email [string], password [string]

- https://domain.com/api/user/recover-password
  — method POST/PATCH
  — fields: email [string] // allow to update the password via email token

- https://domain.com/api/user/companies
  — method GET
  — fields: title [string], phone [string], description [string]
  — show the companies, associated with the user (by the relation)

- https://domain.com/api/user/companies
  — method POST
  — fields: title [string], phone [string], description [string]
  — add the companies, associated with the user (by the relation)

Unit tests are optional.

# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

# Deploy

## Setup yor .env file and database 
### PHP version: `7.2.34`

`composer install`

`php artisan migrate`

`php artisan db:seed`

`php artisan serve` 

### use postman collection in root dir to test
