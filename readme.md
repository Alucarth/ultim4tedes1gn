<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Ultimate Design


## Install

cp .env.example .env  
composer install   
yarn or npm Install  
php artisan key:generate  
php artisan jwt:secret  

## .env 
add url proyect into .env file

example "http://ultim4tedes1gn.test" 

APP_URL=http://ultim4tedes1gn.test

then make run: npm run dev

## Utils
for send a message with vuex use this:

this.$store.dispatch('template/showMessage',{message:'Se registro correctamente el Gasto ',color:'success'});

where color options is 'success', 'info', 'error'

## Contributing

Thanks Brian cerrucho XD

