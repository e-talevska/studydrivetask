Image gallery - Test project for Studydrive
============================

This project is an online tool for favoriting/unfavoriting photos. 
It's created as custom Laraval, Vue.js, Bootstrap and MySQL.

### Prerequisites

What things you need to install the software.

* Git
* PHP
* Composer
* Laravel CLI (optional)
* A webserver like Nginx or Apache (optional)
* A Node Package Manager

## Installation

Clone the git repository on your computer
```
$ git clone https://github.com/e-talevska/studydrivetask.git
```

You can also download the entire repository as a zip file and unpack in on your computer if you do not have git

After cloning the application, you need to install it's dependencies. 
```
$ cd studydrivetask
$ composer install
```

### Setup
- When you are done with installation, copy the `.env.example` file to `.env`
```
$ cp .env.example .env
```

- Generate the application key
```
$ php artisan key:generate
```

- Install Passport
```
$ php artisan passport:install
```

- Add your database credentials to the necessary `env` fields

- Migrate the application
```
$ php artisan migrate
```

- Seed Database
```
php artisan db:seed
```

- Cearte Personal Client
```
php artisan passport:client --personal
```

- Install node modules
```
$ npm install
```

### Run the application
```
$ php artisan serve
```

## Built With
* [Laravel](https://laravel.com) - The PHP framework for building the API endpoints needed for the application
* [Vue](https://vuejs.org) - The Progressive JavaScript Framework for building interactive interfaces
