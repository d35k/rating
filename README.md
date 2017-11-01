# Laravel Rating
Rating system for laravel 5

## Installation

First, pull in the package through Composer.

```js
composer require d35k/rating
```
or add this in your project's composer.json file .
````
"require": {
  "d35k/Rating": "^0",
}
````

And then include the service provider within `app/config/app.php`.

```php
'providers' => [
    d35k\Rating\RatingServiceProvider::class
];
```

-----
## Getting started
After the package is correctly installed, you need to generate the migration.
````
php artisan rating:migration
````

It will generate the `<timestamp>_create_ratings_table.php` migration. You may now run it with the artisan migrate command:
````
php artisan migrate
````

After the migration, one new table will be present, `ratings`.

## Usage
### Setup a Model
```php
<?php

namespace App;

use d35k\Rating\Traits\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements Rating
{
    use Rating;
}
```

### Create a rating
```php
$user = User::first();
$post = Post::first();

$rating = $post->rating([
    'rating' => 5,
    'rating_question' => 'question',
    'author_role' => 'role'
], $user);

dd($rating);
```

### Create or update a unique rating (Usefull for unknown question)
```php
$user = User::first();
$post = Post::first();

$rating = $post->ratingUnique([
    'rating' => 5,
    'rating_question' => 'question',
    'author_role' => 'role'
], $user);

dd($rating);
```

### Update a rating
```php
$rating = $post->updateRating(1, [
    'rating' => 3
]);
```

### Delete a rating:
```php
$post->deleteRating(1);
```

### fetch the Sum rating:
````php
$post->sumRating

// $post->sumRating() also works for this.
```` 

### fetch the average rating:
````php
$post->avgRating

// $post->avgRating() also works for this.
````
### fetch the average rating by filter:
````php
$post->avgRatingByFilter('column', 'filter')

````

### fetch the rating percentage. 
This is also how you enforce a maximum rating value.
````php
$post->ratingPercent

$post->ratingPercent(10)); // Ten star rating system
// Note: The value passed in is treated as the maximum allowed value.
// This defaults to 5 so it can be called without passing a value as well.
````

### Count positive rating:
````php
$post->countPositive

// $post->countPositive() also works for this.
````

### Count negative rating:
````php
$post->countNegative

// $post->countNegative() also works for this.
````
