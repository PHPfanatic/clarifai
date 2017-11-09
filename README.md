# Clarifai PHP Library 
[![Build Status](https://travis-ci.org/PHPfanatic/clarifai.svg?branch=master)](https://travis-ci.org/PHPfanatic/clarifai)
[![GitHub version](https://badge.fury.io/gh/phpfanatic%2Fclarifai.png)](https://badge.fury.io/gh/phpfanatic%2Fclarifai)

Clarifai API Library, PHP/Composer implementation of the clarifai api. ([clarifai](https://clarifai.com/)).
PHPfanatic's PHP library brings you the power of clarifai's image recognition API wrapped in an easy to use PHP library that you can
add to your own project easily with composer.

Build smarter apps faster with Clarifai’s powerful visual recognition technology.

## Getting Started

Add the package to your composer implementation.
```
composer require phpfanatic/clarifai
```

or

Add the package manually by downloading the most recent stable version release from Github and include the src/ directory
within your own project.

* [zip](https://github.com/PHPfanatic/clarifai/archive/2.0.1.zip)

* [tar](https://github.com/PHPfanatic/clarifai/archive/2.0.1.gz)

### Requirements

* PHP - 5.6, 7.0 - May work with ealier version, untested at this time.
* cURL - *
* Clarifai API Key - [clarifai](https://developer.clarifai.com/pricing/) 
* PHPUnit - to run tests (optional).

### Example Usage

```
use PhpFanatic\clarifAI\ImageClient;

$client = new ImageClient([API_KEY]);

$client->AddImage('http://phpfanatic.com/projects/clarifai/dog.jpg');
$result = $client->Predict();
```

## Documentation

[PHPfanatic - ClarifAI documentation](https://github.com/PHPfanatic/clarifai/wiki/)

## Change History
* 2.0.1 - Patched clientversion variable.
* 2.0.0 - Changed Clarifai authentication to use API Key method.
* 1.2.3 - Added User-Agent Library header to outbound curl calls per Clarifai request.
* 1.2.2 - Fixed malformed url bug when you paginate a get request. (credit: @mhdere)
* 1.2.1 - Fixed urlencode bug (credit: keithslater), added additional Clarifai models.
* 1.2.0 - Added model delete support, updated inputs to allow delete all.
* 1.1.0 - Added multi language support.
* 1.0.0 - Public API release.
* 0.1.1 - Development alpha release.

## Look Ahead (what might be changed in the future.)

* Removing cURL as a requirement.
* Combining POST,DELETE,PATCH into a single method.

## Built With

* [Composer](https://getcomposer.org/) - Dependency management
* [PHPUnit](https://phpunit.de/) - Testing framework
* [Packagist](https://packagist.org/) - Package repository
* [Travis CI](https://travis-ci.org/) - Automated building

## Authors

* **Nick White** - *Initial work* - [PHPfanatic](https://github.com/PHPfanatic)

## License

This project is licensed under the MIT License.
