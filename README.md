# Thecats library for Laravel

This package makes it easy to manage Cat images using [Thecats](https://docs.thecatapi.com/) with Laravel 7.x

## Installation

You can install the package via composer. Add following lines to your composer.json file.

To **repositories** section:
```json
"repositories":[
    {
        "type": "vcs",
        "url": "https://github.com/rapeksz/cats.git"
    }
]
```

To **require** section:
```json
"require": {
    "rszewc/thecats": "1.0.x"
}
```

Use following command to install **Thecats** library
```bash
composer update
```

You can publish the provider with:
```bash
php artisan vendor:publish --provider="Rszewc\Thecats\CatsServiceProvider"
```

You can publish the config file with
```bash
php artisan vendor:publish --tag=config
```


## Setting up the Cats library

Log in to your [Cats](https://thecatapi.com/) dashboard and get your API token.
Set your api token in `config/cats.php`:

```php
return [
    'auth' => [
        'key' => env('CATS_API_KEY'),
    ],
];
```

## Usage

You can use the Cats library in your Controller:

```php
namespace App\Http\Controllers;

use Rszewc\Thecats\Cats;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;

class CatsController extends Controller
{
    /**
     * @var Cats 
     */
    private $cats;

    /**
     * @param Cats $cats
     */
    public function __construct(Cats $cats)
    {
        $this->cats = $cats;
    }

    /**
     * @return Response
     */
    public function index() : JsonResponse
    {
        $cats = $this->cats->votes()->showAll();
        return response()->json($cats, 200);
    }
}
```

Here's how to create a Vote:

```php
$client = new ThecatsHttpClient('API_KEY');
$vote = Vote::create([
    'image_id' => '1234-test',
    'value' => 1234,
    'sub_id' => '1234', //optional
]);
$cats = new Cats($client);
$votes = $cats->votes();
$response = $votes->create($vote);
$message = $response->getMessage();
```


## Credits

- [Rafał Szewc](https://github.com/rszewc)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.