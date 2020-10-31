<p align="center"><a href="https://pharaonic.io" target="_blank"><img src="https://raw.githubusercontent.com/Pharaonic/logos/main/short-url.jpg" width="470"></a></p>

<p align="center">
[![Source](http://img.shields.io/badge/source-pharaonic/laravel--short--url-blue.svg?style=flat-square)](https://github.com/Pharaonic/laravel-short-url) ![Packagist Version](https://img.shields.io/packagist/v/pharaonic/laravel-short-url?style=flat-square)
[![Laravel](https://img.shields.io/badge/Laravel->=6.0-red.svg?style=flat-square)](https://laravel.com) ![Packagist Downloads](https://img.shields.io/packagist/dt/pharaonic/laravel-short-url?style=flat-square) [![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)
</p>



## Install
Install the latest version using [Composer](https://getcomposer.org/):

```bash
$ composer require pharaonic/laravel-short-url
$ php artisan vendor:publish --tag=laravel-short-url
$ php artisan migrate
```


## Usage
- [Generate (URL, Route)](#generate)
- [Get URL](#read)
- [IF Expired](#expired)
- [Re-Generate Short URL](#regenerate)



<a name="generate" id="generate"></a>

#### Generate (URL, Route)

```php
// Generate from URL
shortURL()->generate('https://pharaonic.io');

// Generate from URL with Expiry date (string or Carbon object)
shortURL()->generate('https://pharaonic.io', '2027-07-07');



// Generate from Route
shortURL()->generate('route.name.here', ['param' => 1]);

// Generate from Route with Expiry date (string or Carbon object)
$shortURL = shortURL()->generate('route.name.here', ['param' => 1], '2027-07-07');



// RESULT AS OBJECT
Pharaonic\Laravel\ShortURL\ShortURL { ▼
  ...
  #original: array:7 [▼
    "code" => "97b3b32933"
    "type" => "url"
    "data" => "{"url":"https:\/\/pharaonic.io"}"
    "expire_at" => "2027-07-07 00:00:00"
    "user_id" => null
    "updated_at" => "2020-10-31 07:07:00"
    "created_at" => "2020-10-31 07:07:00"
  ]
  ...
}


// RESULT AS ARRAY
array:7 [▼
  "code" => "97b3b32933"
  "type" => "url"
  "data" => array:1 [▼
    "url" => "https://pharaonic.io"
  ]
  "expire_at" => "2027-07-07T00:00:00.000000Z"
  "user_id" => null
  "updated_at" => "2020-10-31 07:07:00.000000Z"
  "created_at" => "2020-10-31 07:07:00.000000Z"
]
```



<a name="read" id="read"></a>

#### Get URL

```php
echo shortURL('3dc0c3deda')->url;    //      http://127.0.0.1:8000/97b3b32933

// Blade
@shortURL('3dc0c3deda')  				//      http://127.0.0.1:8000/97b3b32933
```



<a name="expired" id="expired"></a>

#### IF Expired

```php
shortURL('3dc0c3deda')->expired		// false
```



<a name="regenerate" id="regenerate"></a>

#### Re-Generate

```php
shortURL('3dc0c3deda')->regenerate()		// Returns ShortURL Object

// RESULT
Pharaonic\Laravel\ShortURL\ShortURL { ▼
  ...
  #original: array:7 [▼
    "code" => "97b3b32933"
    "type" => "url"
    "data" => "{"url":"https:\/\/raggitech.com"}"
    "expire_at" => "2027-07-07 00:00:00"
    "user_id" => null
    "updated_at" => "2020-10-31 07:07:00"
    "created_at" => "2020-10-31 07:07:00"
  ]
  ...
}
```


## License

[MIT LICENSE](LICENSE.md)
