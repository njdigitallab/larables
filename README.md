# Larables

### About

Larables is a laravel package that allows you to seemlessly generate html tables entirely using PHP classes.

### Installation

Install with composer `composer require njdigitallab/larables`.

### Setup

Publish the package assets with artisan command `php artisan vendor:publish --tag=larables-assets`.

Then include the `larables.js` script in your html markup.

`<script src="{{ asset('vendor/larables/js/larables.js') }}" defer></script>`

The `larables.js` must be included in your html markup if you need the built in functionality of bulk request including checkboxes selection, per page option, search function and sorting columns.

### Getting Started

Create your class and extend the `Larables\Table` class.

```php
<?php

namespace App\Tables;

use App\Models\Post;
use Larables\Table;

class PostsTable extends Table
{

}
```

Then in your controller, create an instance of the table by calling the static `make` method and pass it to your view. In your view file, include the `larables::larables` partial view, which is already setup to render your table based on your class setup. The `laratables::larables` partial view requires the table instance to be passed in a variable named `$table`.

```php
<?php

namespace App\Http\Controllers;

class PostController extends Controller
{
    /**
     * Render the view for the posts listing.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $table = PostsTable::make();
        return view('posts.index', compact('table'));
    }
}
```

And in your view file...

```html
@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
    @include(Larables::viewsId().'::larables')
@endsection
```
