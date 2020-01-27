# laravel-mixin

[![Travis CI Build Status](https://travis-ci.org/Tarik02/laravel-mixin.svg?branch=master)](https://travis-ci.org/Tarik02/laravel-mixin)
[![Latest Stable Version](https://poser.pugx.org/tarik02/laravel-mixin/version.png)](https://packagist.org/packages/tarik02/laravel-mixin)
[![Total Downloads](https://poser.pugx.org/tarik02/laravel-mixin/d/total.png)](https://packagist.org/packages/tarik02/laravel-mixin)
[![Packagist License](https://poser.pugx.org/tarik02/laravel-mixin/license.png)](http://choosealicense.com/licenses/mit/)

Take class, some traits and interfaces and put them in one place. For example, add new methods, relations, etc. to existing model without touching it. Very useful for dividing project into packages without loosing ability to improve.

NOTE: This can only be used with special packages which are ready to use this package. See below for more information.


## Installation

```bash
$ composer require tarik02/laravel-mixin
$ mkdir -p storage/framework/mixin
$ echo "*\n\!.gitignore" > storage/framework/mixin/.gitignore
```


## Commands

The package provides the following commands:

```bash
$ php artisan mixin:generate     # Generate all mixins
$ php artisan mixin:cache        # Cache all mixins and use only cache
$ php artisan mixin:cache:clear  # Clear mixins cache
```

Cache should only be used in production and be regenerated after every code change. 


## Documentation

You can generate documentation using the Sami. Documentation for master branch is always available [here](https://Tarik02.github.io/laravel-mixin/).

## Usage example

Create your model class (note, the class is `abstract`):

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
abstract class Article extends Model
{
    //
}
```

Create `App\Providers\MixinServiceProvider`:

```php
<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\ServiceProvider;

class MixinServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $mixin = $this->app->make('mixin');

        $mixin
            ->register(\Models\Article::class, \App\Models\Article::class)
            ->mixTrait(SoftDeletes::class)
        ;

        $mixin
            ->class(\Models\Article::class)
            ->mixInterface(MyInterface::class)
        ;
    }
}
```

Add `MixinServiceProvider` before `AppServiceProvider` to `providers` section in config:

```php
+        App\Providers\MixinServiceProvider::class,
         App\Providers\AppServiceProvider::class,
```

Now you have to use `\Models\Article` class instead of `\App\Models\Article` (really, you can name it whatever you want).


## Under the hood

Actually, the code above generates class which extends specified class, uses specified traits and implements specified interfaces. Classes are located at `storage/framework/mixin` and can be cached (see Caching section). Here's how the class looks like:

```php
<?php

namespace Models;

use App\Models\Article as Base;

class Article
    extends Base
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
}
```


## License

The package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

