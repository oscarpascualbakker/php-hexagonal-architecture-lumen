# Hexagonal Architecture using Lumen

This code is a very small example of Hexagonal Architecture in PHP.  In this example I clearly differenciate between the layers of this clean architecture, following the tipical schema...

[![Hexagonal Architecture using Lumen](https://www.oscarpascual.com/wp-content/uploads/2021/09/hexagonal-architecture-thumb.jpg)](https://www.oscarpascual.com/wp-content/uploads/2021/09/hexagonal-architecture-thumb.jpg)

*Image credit: [Fideloper](https://fideloper.com/hexagonal-architecture)*

I wanted this small API demo to be a totally [RESTful](https://en.wikipedia.org/wiki/Representational_state_transfer "Wikipedia") API.  And I built it using [Lumen](https://lumen.laravel.com/ "Lumen website") because it is an easy framework to start with.

## Elements you'll find in this development

I use a clear separation of all layers.  I even separate the framework controllers from the infrastructure layer controllers.  The ultimate idea behind this is to be able to move this code to another framework by moving only the src folder, and perform some minor changes.

In this development you'll find a bit of the following:

* Docker & Docker compose
* Migration files (Eloquent)
* SOLID
* Design patterns (adapter & repository, among others)
* Value Objects
* Event/Listeners infrastructure
* Unit testing **with code coverage**
* Debug capabilities with XDebug
* Dynamic caching techniques with Redis
* Monitoring with Prometheus/Grafana
* Error tracking with Sentry

I could manage to develop this in a relatively short time, so it is possible that you find some room to improve.  If so, let me know.  I am more than happy to credit you... ;-)

## Requirements

* Docker
* Postman (because you'll need to create at least one user)

## Installation

The installation process should be relatively easy.  Just clone the repo and create all the containers with:
```sh
$ docker-compose up -d
```

Once everything is up & running, enter the 'hex_arch_api' container terminal.  I use portainer (and I love it!), but you can use your preferred tool.

You should be in */var/www/html* directory.  Move to */var/www/html/project* in order to install all the dependencies:
```sh
$ composer update
```

Once everything is installed, check the following URL in your browser: [http://localhost](http://localhost)

You should see something similar to this: **Lumen (8.2.4) (Laravel Components ^8.0)**

From the same directory, execute the following instructions in order to allow log storage:
```sh
$ chown www-data:www-data -R storage
$ chmod 777 -R storage
```

Let's create the database, now.  Execute this from the same directory:
```sh
$ php artisan migrate:install
$ php artisan migrate
```

Move to [phpMyAdmin](http://localhost:8080 "phpMyAdmin") (localhost:8080) and log in (user: root; password: root).  If everything is OK you should see a database called 'hex_arch_test' with a couple of tables.

Now, from your postman, import the json file named 'HexArch-Lumen.postman_collection.json' in the root directory of this repo.

You should be able to perform the following operations:
1. Create a user (POST)
2. Get a user (GET)
3. Update a user (PUT)
4. Delete a user (DELETE)

**Everything should be in place, now!**

## Let's make things work

Create a couple of users via Postman and then move again to [phpMyAdmin](http://localhost:8080 "phpMyAdmin") in order to check both records.

But this is not the only thing that has happened!  Let's check also the other magic that should have happened:
* User should be saved in Redis
* An email should have been sent
* The 'new users' counter should have been increased

#### Checking Redis
Move into your Redis container terminal (called 'hex_arch_redis') and type the following:

```sh
$ redis-cli
```
We now are going to check if there is a key with the newly created user, and then we will retrieve that key.  In theory, the Redis record should be named 'hexagonal_architecture_using_lumen_database_user_1'.

```sh
$ KEYS *
$ GET hexagonal_architecture_using_lumen_database_user_1
```

The last instruction should return a serialized User object.

#### Checking email

Now let's see if we sent the email message.  We didn't really send an email.  Instead, the system wrote a line into the log file.  Your log file is called *./storage/logs/lumen-YYYY-MM-DD.log*

You should see something like this in the log file:
*[2021-09-12 18:32:11] local.INFO: I have sent an email to the new user with ID 1.*

#### Checking Prometheus & Grafana

And the last thing to check is the new users counter.  Let's point the browser to [Prometheus](http://localhost:9090 "Prometheus") (localhost:9090) and in the first text box you see, type this: *api_create_user_total*

If everything is OK you should see the number of users you just created.  This is quite OK, but Prometheus is not exactely the most powerful visualization tool, so we are going to put Grafana on top of it.

Point your broser to [Grafana](http://localhost:3000 "Grafana") (localhost:3000) and log in with admin/MYPASSWORT.

You should see three different dashboards, there.  Try them all out.  One is for MySQL, another one for Prometheus itself, and the last one, called 'API', is the one with the counter of new users.

#### Testing the code

Execute the tests by entering the api container and executing the following in the */var/www/html/project* folder (configuration is applied by default):

```sh
$ vendor/bin/phpunit
```

Everything should be green (9 tests, 22 assertions)

**And that's pretty much it!**



## All components explained

In this section I'll give all the details of the services available in this project.

### phpMyAdmin
[http://localhost:8080](http://localhost:8080) (root/root)

Does this really need an explanation?  The MySQL manager I like.  For production environments I prefer to connect via MySQL Workbench.

Learn more: [phpMyAdmin website](https://phpmyadmin.net)

### Redis
Redis is a key/value database.  It can store in memory or it can also save its data to a persistence layer (disk).  Almost everybody uses Redis as cache, because it permits some operations that differs from "normal" caches.

If you want to see what it is storing at any time, enter the container and execute this:
```sh
$ redis-cli
```

Once there, enter KEYS * and see what it returns.  If you want to see what one particular key holds, type GET and the key name.

Learn more: [Redis website](https://redis.io)

### Prometheus
[http://localhost:9090](http://localhost:9090) (no credentials needed in this development)

In our API, accessing [http://localhost/metrics](http://localhost/metrics) you should see a kind of log file containing the data for Prometheus.  It's all good if you don't see an error.

Learn more: [Promethes website](https://prometheus.io)

### Grafana
[http://localhost:3000](http://localhost:3000) (admin/MYPASSWORT)

Grafana is a great visualization tool and it integrates smoothly with Prometheus.  I love this part because it gives a clear vision about the performance of your API.

Learn more: [Grafana website](https://grafana.com)

### Testing & Code Coverage
This project is set up to use PHPUnit.  The tests are implemented with code coverage options.  Try to get the best out of it.

I integrate testing both in PHPStorm and Visual Studio Code.  It's not my intention to explain how to do so.  Check this [tutorial to integrate testing into PHPStorm](https://www.jetbrains.com/help/phpstorm/performing-tests.html).


### XDebug
If you plan to Step Debug you application, change the value xdebug.mode from 'develop' to 'debug'.  You should do this in your container, but preferably also in your config file (.docker/xdebug/xdebug.ini).

XDebug is easy to configure in PHPStorm and Visual Studio Code.

[Tutorial to integrate XDebug into PHPStorm](https://www.jetbrains.com/help/phpstorm/zero-configuration-debugging.html) (called "Zero configuration").

### Sentry
If you are interested in using Sentry you will need to do several things:
* get your DSN from Sentry's website
* uncomment lines 39 to 41 in /app/Exceptions/Handler.php.
* uncomment lines 128 and 129 from /bootstrap/app.php.
* uncomment lines in .env and put your own Sentry values.

You should configure alerts in Sentry.  This is the best part of it, in my opinion.


## Further improvements or TODO's
There are lots of things to improve.  I only mention a few in the following list.

I kindly ask you to send me your comments if you find something to add or improve.

* Create RabbitMQ subscribers (by now it uses Lumen's event/listener feature)
* Add an external logger that can feed Prometheus
* Use UUID instead of MySQL IDs (needed for decoupling from framework AND database)
* Use doctrine as ORM as it will help with the tricky things, like mapping doctrine objects directly to Domain objects
* Add Criteria pattern to search by name or email (or any other value you might need)
* Add Swagger UI for documentation


## Comments
As usual, don't hesitate to give me your feedback.  I'm glad to improve this code with your help.

And if you like this code, why don't you buy me a coffee?  :-)

[![Buy me a coffee](https://www.oscarpascual.com/wp-content/uploads/2021/01/coffee.png)](https://buymeacoffee.com/oscarpascual)

### **Cheers!**