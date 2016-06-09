Developing for Business
=======================

#### User Story

I as a guest user, I want to add a product sold out in my wish list, so that I receive a notification when it becomes available.

Eu como um usuário convidado, quero adicionar um produto esgotado em minha lista de desejos para que eu receba uma notificação quando ele estiver disponível.


#### Requirements

* PHP 5.6+
* PDO + SQLite Driver

#### Run Application

create sqlite database
```shell
$ php cli/create_tables.php
```

start php built-in server
```shell
$ php -S localhost:8000 -t public
```