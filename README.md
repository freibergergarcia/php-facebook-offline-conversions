# php-facebook-offline-conversions

Send offline conversion events to a Facebook dataset reading from a csv file.

https://developers.facebook.com/docs/marketing-api/offline-conversions

## Getting started

Clone the repository in you local machine
```
$ git clone https://github.com/freibergergarcia/facebook-offline-conversions.git
```

### Installing

To install all dependencies run

```
$ composer update
```

### Setting up the environment variables

You should edit the file [.env.dev](.env.dev) with the Facebook credentials. To get the credentials,
follow the Setup items 1 to 6 on the offline conversion link above. 

### Requirements

* PHP 7.2
* Composer

### Running the tests
```
$ vendor/bin/phpunit
```
If you need to change any of the config edit the [phpunit.xml](phpunit.xml).
Logs can be seen [here](tmp/testdox.txt).
