# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Important recomendations
This project was created with php 7.3 using lumen/laravel framework, is not necesary make all configuration only 
the env file to connect to the database, and the section databases to create the table and database. Is not necesary make the section to cloudAMQP because the project functions with my account and my configurations.

## Requirements
Install wampserver 64bits
Install composer to instal packages in the projects and handle dependencies
Install Lumen framework
## First steps

we need install a server to run mysql and php, the most recomended are XAMPP and WAMPSERVER this solution use wamppserve, download from page [wamppserver](http://www.wampserver.com/en/), select the option for 64 bits if your pc use this arquitecture or 32 bits option.

install the wampserver a configure de php version to run the project in this case PHP 7.2.14, then run de application wampserver and active the php module and mysql module, then run the route http://localhost/phpmyadmin
in the menu wamppserver like in the image select mySQL console

![console](https://user-images.githubusercontent.com/22681704/56006912-5e676a00-5c9c-11e9-845b-48ebce76ec44.png)

then enter the user in this case use user root and press enter like in the image

![user](https://user-images.githubusercontent.com/22681704/56006968-8fe03580-5c9c-11e9-9175-bde22b2bbe1b.PNG)

in the console enter SET PASSWORD FOR root@localhost = PASSWORD('YOUR_PASSWORD'); and enter, now we need modify the config.inc.php file in the route "C:\wamp64\apps\phpmyadmin4.8.4\config.inc.php" and change the password like in next image.

![passw](https://user-images.githubusercontent.com/22681704/56007507-97084300-5c9e-11e9-9a53-03fb179ad1a2.PNG)

save the file and restart the service for mysql and phpmyadmin then use the link http://localhost/phpmyadmin and enter in the form login the user:root and the password:YOUR_PASSWORD

## Install composer 
Download from the composer page the [composer_setup.exe](https://getcomposer.org/download/), run the .exe in case your OS is windows, follow the instruction, in the setup, select the php version and install

## Install lumen-laravel framework
After installing composer, run a cmd console and write composer global require "laravel/lumen-installer", upon completion create the project with the command composer create-project --prefer-dist laravel/lumen project_wine or 
in the prefer IDE install git plugin and clone the project from github using the link https://github.com/radamanthiss/project_wine.git.

## Configure cloudAMQP
configure a instance for rabbitMQ, the proyect use link CloudAMQP, here use the option Create new instance

![clouamqp](https://user-images.githubusercontent.com/22681704/56008512-07fd2a00-5ca2-11e9-8c6c-87aa0efa3c19.PNG)

Then write the name for a new instance and select the option select region

![name](https://user-images.githubusercontent.com/22681704/56008559-22370800-5ca2-11e9-942b-498f27e96df4.PNG)

Then choose the option for a datacenter and choose the bottom review, finally confirm the create of instance

![confirm](https://user-images.githubusercontent.com/22681704/56008715-c7ea7700-5ca2-11e9-8b1f-8f017789eaf4.PNG)

Finally configure with the details variables in the section of our instance, and replace the parameters in the archive 
(project_name/app/Http/Controllers/HomeController) in the functions recibir and show. the parameters to change are $host, $user, $pass, $port, $vhost

We can see the details after create a instance, if we want to see the rabbitMQ manager, choose the bottom 
like in the image

![details](https://user-images.githubusercontent.com/22681704/54213351-41c7ee80-44b2-11e9-814a-237101892497.PNG)

## RabbitMQ Manager

After configure the instance we can access to rabbitMQ manager, in this page we can administer the Queue

![rabbit](https://user-images.githubusercontent.com/22681704/54213574-a2efc200-44b2-11e9-998c-613f6e13468f.PNG)

## Databases
Run the phpmyadmin in the route (http://localhost/phpmyadmin) and create a new databases with any name
then configure in the .env file in the project the parameters to connect to database like in the next image.

![database](https://user-images.githubusercontent.com/22681704/56010477-59f57e00-5ca9-11e9-8c08-cb88ffe4743e.PNG)

Then we need to create the table to load the wine list, using the command php artisan make:migration create_wine_table
we create the archive in database/migrations and in this archive modify the funcion up to create the table like in the
image

![table](https://user-images.githubusercontent.com/22681704/56010861-f2403280-5caa-11e9-9938-31e8426428b4.PNG)

Then in the route project_name in a cmd console run php artisan migrate and the table is create in the database

## Project structure

After configure all requirements and files, we can see the different routes for the project. The project is a combination of rest api and web page

### Rest API
Run the command > ## php -S localhost:8000 -t public in a cmd console to start the differents routes in the project.

we have the routes:
1. (http://localhost:8000/load_wine) this route was created to load the data one time from the wine url (https://www.winespectator.com/rss/rss?t=dwp)

2. (http://localhost:8000/update_wine) this route was created to update any time the data in the table wine.

both routes are of POST type

### load_wine

we can load the data into the table using the postman api like this:
(http://localhost:8000/load_wine) and pass a json parameters:

![load2](https://user-images.githubusercontent.com/22681704/56012398-f15ecf00-5cb1-11e9-9a25-9e99d8770ed5.PNG)

the response if the load is succesfull is true

### update_wine

we can update the data into the table using the postman api, the function truncate the table and update with the wine link.
(http://localhost:8000/load_wine) and pass a json parameters:

![load](https://user-images.githubusercontent.com/22681704/56011993-f28efc80-5caf-11e9-9c17-3185bcb9c660.PNG)

the response if the load is succesfull is true
 
# Web Page

## Home
For use the application we launch the route (http://localhost:8000/home) on this page we can find the wine list
in this page we press the bottom submit and the wine select is send to queue.

![home](https://user-images.githubusercontent.com/22681704/56013224-510aa980-5cb5-11e9-84f7-c4cddcbe9be4.PNG)

## Validation
When the queue is created, load a page called validation, this page show a message and a bottom indicate that we can see the answer.

![principal](https://user-images.githubusercontent.com/22681704/56013586-17d33900-5cb7-11e9-9c70-5e49f11ced90.PNG)

when press the botton show, redirect to a show page, in this page i consume the queue and show the answer to the user
we can see the queue created like in this image

![queue](https://user-images.githubusercontent.com/22681704/56014004-0c810d00-5cb9-11e9-8df5-149662962d16.PNG)

And get the message

![message](https://user-images.githubusercontent.com/22681704/56014011-186ccf00-5cb9-11e9-8eb9-30daae945a06.PNG)

## Show

This page consume the queue and show the message to the user

![show](https://user-images.githubusercontent.com/22681704/56013923-b4e2a180-5cb8-11e9-8afa-331c78d208b6.PNG)

Finally we can see that the queue is empty

![empty](https://user-images.githubusercontent.com/22681704/56014034-34707080-5cb9-11e9-81ee-4c40fb021de4.PNG)


## Logs in the application

we can find the log in the route project_name/storage/logs/lumen-fecha.log

![log](https://user-images.githubusercontent.com/22681704/56014223-f6c01780-5cb9-11e9-861e-11c4bf040a32.PNG)


# Routes

Configure the different route in the web.php file in the path project_name/routes/web.php

![routes](https://user-images.githubusercontent.com/22681704/56014278-3f77d080-5cba-11e9-9f13-3d2c1dac5fa6.PNG)

# Controllers

We have two controller files HomeController.php and RssController.php, in homeController, we have functions to redirect to views and the create and consume logic queue
in RssController we have functions to load data an update data in the table wine

## HomeController

We found the functions inicio, recibir and show, the function inicio render de view Home.blade.php, the function recibir, create the queue with the wine seleccte and 
publish the message in the queue and render de view principal.blade.php finally the function show, consume the publish queue and render the view show.blade.php

![controller1](https://user-images.githubusercontent.com/22681704/56014436-fc6a2d00-5cba-11e9-9e7d-02c7e9b877b6.PNG)

Continuation

![controller2](https://user-images.githubusercontent.com/22681704/56014484-2d4a6200-5cbb-11e9-9a8b-b763096d1fdc.PNG)

Continuation

![controller3](https://user-images.githubusercontent.com/22681704/56014499-3b987e00-5cbb-11e9-8482-9c64d7e980fb.PNG)

## RssController

in this file we have the functions readRss and updateWine, the function readRss load the data in the table wine, and the function updateWine update the data truncate the table.

readRss function

![rss](https://user-images.githubusercontent.com/22681704/56014672-dabd7580-5cbb-11e9-815c-7eeb2bf33308.PNG)

updateWine function

![update](https://user-images.githubusercontent.com/22681704/56014707-f9237100-5cbb-11e9-8cb5-7ba9d0c04fd7.PNG)

