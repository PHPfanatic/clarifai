# clarifAI PHP Library
[![Build Status](https://travis-ci.org/PHPfanatic/clarifai.svg?branch=master)](https://travis-ci.org/PHPfanatic/clarifai)
Description

## Getting Started

These instructions will get you a copy of the library.  

Add the package to your composer impelementation.
```
composer require phpfanatic/clarifai

```

### Requirements

* PHP - 5.6, 7.0
* cURL - *
* PHPUnit - to run tests (optional).

### Example Usage

```
use PhpFanatic\clarifAI\ImageClient;

$client = new ImageClient([CLIENT_ID], [CLIENT_SECRET]);

$client->AddImage('http://phpfanatic.com/projects/clarifai/cat.png');
$result = $client->Predict();
```

##Documentation
[PHPfanatic - ClarifAI documentation](https://github.com/PHPfanatic/clarifai/wiki/ClarifAI-Library-Documentation)

## Built With

* [Composer](https://getcomposer.org/) - Dependency management
* [PHPUnit](https://phpunit.de/) - Testing framework
* [Packagist](https://packagist.org/) - Package repository
* [Travis CI](https://travis-ci.org/) - Automated building

## Authors

* **Nick White** - *Initial work* - [PHPfanatic](https://github.com/PHPfanatic)

## License

This project is licensed under the MIT License.