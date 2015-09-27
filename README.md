README
==============

This is my first project written using PHP framework Symfony2 and Doctrine ORM. Please don't be too strict judge.	

Technologies
-----------------

PHP framework symfony 2.7.5
MySQL Server 5.6.19
Doctrine ORM 2.4.8
PHPUnit 4.6.6
Composer

Preparation
-----------------

open in browser file config.php - this script will guide you through the basic configuration of your project

$ php app/console doctrine:database:create - create DB

$ php app/console doctrine:schema:update --force  - create DB Tables/Schema

$ composer update - download/update all needed packages from composer.json



Structure
-----------------

$ tree src/Acme/FriendshipBundle/ - bundle(plugin) for managing relationships

├── AcmeFriendshipBundle.php
├── Controller
│   ├── ExceptionController.php
│   ├── RelationshipController.php
│   └── UserController.php
├── DependencyInjection
│   ├── AcmeFriendshipExtension.php
│   └── Configuration.php
├── Entity
│   ├── Relationship.php
│   ├── Relationship.php~
│   ├── RelationshipRepository.php
│   ├── User.php
│   ├── User.php~
│   └── UserRepository.php
├── Helper
│   ├── JsonHelper.php
│   └── Validation.php
├── Resources
│   ├── config
│   │   └── services.xml
│   └── views
└── Tests
    └── Controller
        ├── RelationshipControllerCreateActionTest.php
        ├── RelationshipControllerDeleteActionTest.php
        ├── RelationshipControllerShowActionTest.php
        └── UserControllerTest.php


Controllers are located in  Controller directory.

Models are located in Entity directory.

Helpers are located in Helpers directory and registered in app/config/services.yml

Template can be located in Resources/view directory. Since this is REST API we don't use templates.

Tests are located in Tests/Controller directory.

Configuration - app/config


API
-----------------

Create relationship: POST /relationship/new 

parameters: user_one_id, user_two_id


Show relationship: GET /relationship/{user_id}


Delete relationship: DELETE /relationship/delete/{user_id}/{user_id_2}


Show user: GET /user/{user_id}

Tests Running
----------------

In case all tests are located in Tests directory you can simply run them using command below

$ phpunit -c app/

Symfony provides good environment management tool which allows to use (for example) separate DB for tests.


Deployment
----------------

Symfony provides a detailed instruction on "[How to Deploy a Symfony Application][1]"



[1]: http://symfony.com/doc/current/cookbook/deployment/tools.html