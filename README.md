# clarifAI PHP Library

Description

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.  

Add the package to your composer impelementation
```
composer require phpfanatic/clarifai

```

If you are using CakePHP you may need to update the composer.json file of the CakePHP app to have the following for namespacing to work correctly:
```
 "autoload": {
        "psr-4": {
            "App\\": "src",
            "PhpFanatic\\clarifAI\\": "./vendor/phpfanatic/clarifai/src"
        }
    },

```

### Requirements

* PHP - 5.6, 7.0
* PHPUnit - to run tests (optional).

### Example Usage

```
Examples...

```

##Documentation


## Built With

* [Composer](https://getcomposer.org/) - Dependency management
* [PHPUnit](https://phpunit.de/) - Testing framework
* [Packagist](https://packagist.org/) - Package repository
* [Travis CI](https://travis-ci.org/) - Automated building

## Authors

* **Nick White** - *Initial work* - [PHPfanatic](https://github.com/PHPfanatic)

## License

This project is licensed under the MIT License.

