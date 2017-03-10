# Clarifai PHP Library 
[![Build Status](https://travis-ci.org/PHPfanatic/clarifai.svg?branch=master)](https://travis-ci.org/PHPfanatic/clarifai)

Clarifai API Library, PHP/Composer implementation of the clarifai api. ([clarifai](https://clarifai.com/)).
PHPfanatic's PHP library brings you the power of clarifai's image recognition API wrapped in an easy to use PHP library that you can
add to your own project easily with composer.

Build smarter apps faster with Clarifai’s powerful visual recognition technology.

## Getting Started

Add the package to your composer impelementation.
```
composer require phpfanatic/clarifai
```

or

Add the package manually by downloading the most recent stable version release from Github and include the src/ directory
within your own project.

* [zip](https://github.com/PHPfanatic/clarifai/archive/0.1.1-alpha.zip)

* [tar](https://github.com/PHPfanatic/clarifai/archive/0.1.1-alpha.gz)

### Requirements

* PHP - 5.6, 7.0 - May work with ealier version, untested at this time.
* cURL - *
* Clarifai API Key - [clarifai](https://developer.clarifai.com/pricing/) 
* PHPUnit - to run tests (optional).

### Example Usage

```
use PhpFanatic\clarifAI\ImageClient;

$client = new ImageClient([CLIENT_ID], [CLIENT_SECRET]);

$client->AddImage('http://phpfanatic.com/projects/clarifai/cat.png');
$result = $client->Predict();
```

##Documentation

[PHPfanatic - ClarifAI documentation](https://github.com/PHPfanatic/clarifai/wiki/Documentation)

## Built With

* [Composer](https://getcomposer.org/) - Dependency management
* [PHPUnit](https://phpunit.de/) - Testing framework
* [Packagist](https://packagist.org/) - Package repository
* [Travis CI](https://travis-ci.org/) - Automated building

## Authors

* **Nick White** - *Initial work* - [PHPfanatic](https://github.com/PHPfanatic)

## License

This project is licensed under the MIT License.