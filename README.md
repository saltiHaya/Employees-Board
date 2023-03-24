# Employee board API 
Employees Board backend APIS

## Built With
Laravel - The web framework used

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites 
- PHP 8.1
- Mysql

### Run the code locally

- Clone the repository:

```git
git clone https://haya-salti@bitbucket.org/haya-salti/employees-board.git
```

- Copy .env:
Copy .env.example to .env

```cp
cp .env.example .env
```

- Create new database and add your credentials to .env file

- Run database migrations and seed:

``` php
php artisan migrate
```

``` php
php artisan db:seed
```

- Start the development server:

``` php
php artisan serve
```

### API Endpoints examples

Auth
- [POST] localhost:8000/api/auth/register
- [POST] localhost:8000/api/auth/login
- [POST] localhost:8000/api/auth/logout

Users List
- [GET] localhost:8000/api/users/role
- [GET] localhost:8000/api/users/role/manager
- [GET] localhost:8000/api/users/role/employee

Get user by id
- [GET] localhost:8000/api/users/1

Update user contact information
- [PUT] localhost:8000/api/users/1

Deactivate an employee
- [PUT] localhost:8000/api/users/deactivate/1