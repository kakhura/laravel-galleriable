## kakhura/laravel-galleriable

This package is for create modules, which has media gallery.
### Docs
* [Installation](#installation)
* [Configuration (Config based management)](#configuration)
* [Migrations](#migrations)

## Installation
Add the package in your composer.json by executing the command.

```bash
composer require kakhura/laravel-galleriable
```

For Laravel versions before 5.5 or if not using **auto-discovery**, register the service provider in `config/app.php`

```php
'providers' => [
    /*
     * Package Service Providers...
     */
    \Kakhura\Galleriable\GalleriableServiceProvider::class,
],
```


## Configuration

If you want to change ***default configuration***, you must publish default configuration file to your project by running this command in console:
```bash
php artisan vendor:publish --tag=kakhura-galleriable-config
```

This command will copy file `[/vendor/kakhura/laravel-galleriable/config/kakhura.galleriable.php]` to `[/config/kakhura.galleriable.php]`

Default `kakhura.galleriable.php` looks like:
```php
return [
    /**
     * Which methods supports this package.
     */
    'request_methods' => [
        'post',
        'put',
    ],

    /**
     * Package use or not auth user check.
     */
    'use_auth_user_check' => false,
];
```

This command will copy file `[/vendor/kakhura/laravel-galleriable/resources/views]` to `[/resources/views/vendor/admin/galleriable]`

## Migrations
After publish [Configuration](#configuration), you must publish **migrations**, by running this command in console:
```bash
php artisan vendor:publish --tag=kakhura-galleriable-migrations
```

This command will copy file `[/vendor/kakhura/laravel-galleriable/database/migrations]` to `[/database/migrations]`

After publish [Migrations](#migrations), you must add `HasGallery` trait in your model which you want to has gallery:
```php
use Kakhura\Galleriable\Traits\Models\HasGallery;

class Post extends Model
{
    use HasGallery;
}

```
You must sync `Gallery` in all your model create functionality like this:
```php

use Models\Post;

class PostService extends Service
{
    public fucntion create(array $data) 
    {
        ...
        $post = Post::create($data);
        $images = [];
        foreach (Arr::get($data, 'images') as $key => $image) {
            $file = Helper::uploadFile($data, $fileType);
            $images[] = [
                'image_id' => $file->id,
                'sort_index' => $key,
            ];
        }
        $post->syncGallery($images);
        ...
    }
}

Enjoy.
