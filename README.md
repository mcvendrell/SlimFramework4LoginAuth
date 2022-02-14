# Slim Framework 4 Login & Auth

A super simple bootstrap example for projects with Slim Framework 4 with login form and basic authenticacion (by PHP session).

The project can run easily with, e.g., XAMPP. You will onlyneed PHP, Apache and MariaDB installed for this example to run.

You will find here:

* An Slim Framework 4 basic skeleton
* Slim Framework settings, DI (Dependency Injection) and routes
* Basic PHP templating usage
* A login form
* A form to save data to the DB (as an example to show auth working)
* A way to authenticate routes in a single place

# Tables for MariaDB

You can create the tables for the project with this scritp:

```
CREATE OR REPLACE DATABASE example;

CREATE TABLE example.users (
	id INT NOT NULL,
	login varchar(50) NOT NULL,
	pass varchar(30) NOT NULL,
	`last` DATETIME DEFAULT NOW() NOT NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

CREATE TABLE example.records (
	user INT NOT NULL,
	`date` DATE DEFAULT NOW() NOT NULL,
	value DECIMAL(15,2) NOT NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

INSERT INTO example.users (id, login, pass, `last`) VALUES (1, '1', '1', NOW());
COMMIT;

```

# Install Slim Framework dependencies

I'm assuming you know how to use Slim Framework, nevertheless, after clone this project, execute (in the command line) `composer install` to install all dependencies.

# Place the project in the right XAMPP folder

By default, the "localserver" will fall in the `XAMPP\htdocs` folder, so place the proyect files there.
My setup is a VirtualHost in Apache, pointing to the public folder:

```
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/SlimFramework4LoginAuth/public"
    ServerName localhost
</VirtualHost>
```

If all is well configured, going to `localhost` will show you a login screen and you can login with user 1 pass 1.
Before login, if you try to access fobidden path `localhost/addData`, you will be redirected to \