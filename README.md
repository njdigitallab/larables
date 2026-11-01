# Larables

- [About](#About)
- [Installation](#Installation)
- [Setup](#Setup)
- [Getting Started](#Getting-Started)
- [Table Data](#Table-Data)
- Columns
    - [Defining Columns](#Defining-Columns)
    - [Customizing Column Content](#Customizing-Column-Content)
    - [Sorting Columns](#Sorting-Columns)
- [Checkbox]
- [Actions]
- [Bulk Options]
- [Per Page Total]
- [Paginate]
- [Search]
- [Active and Trash Sections]
- [Table Foot]

## About

Generate data tables entirely using PHP classes.

## Installation

Install with `composer require njdigitallab/larables`.

## Setup

Publish the package assets with `php artisan vendor:publish --tag=larables-assets`.

Then include the `larables.js` script in your html markup.

`<script src="{{ asset('vendor/larables/js/larables.js') }}" defer></script>`

## Getting Started

Create a class and extend the Larables Table class.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{

}
```

Then in your controller, create an instance of the table by calling the static `make` method and pass it to your view in a variable named `$table`.

```php
<?php

namespace App\Http\Controllers;

use App\Tables\UsersTable;

class UserController extends Controller
{
    public function index()
    {
        $table = UsersTable::make();
        return view('users.index', compact('table'));
    }
}
```

In your view file, include the larables partial view, which is already setup to render your table based on your class setup.

```html
@include(Larables::viewsId().'::larables')
```

## Table Data

You need a data source to work, in this care, from the database. Define a `baseQuery` method on your table class. This method should return an instance of the Eloquent Builder. DO NOT do the following, as they are either handled by the package or will be covered later on:

- Do not return results.
- Do not paginate.
- Do not sort.
- Do not search.

```php
<?php

namespace App\Tables;

use Illuminate\Database\Eloquent\Builder;
use Larables\Table;

class UsersTable extends Table
{
    public function baseQuery(): Builder
    {
        return User::query();
    }
}
```

## Defining Columns

Define columns by adding key value pairs to the `$columns` property. The keys are the column ids and the values are the column title.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected array $columns = [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Email',
    ];
}
```

## Customizing Column Content

Once a column id matches the model property, the model property value will automatically be displayed as the column content. However, if you have a column id that does not correspond to a model property, you can customize the column content. For example, if we have a column id of name and we want to use the value of the models first and last name property, we can do it as follows:

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected array $columns = [
        'name' => 'Name',
        'email' => 'Email',
    ];

    public function getNameColumnContent($model, $columnNumber, $rowNumber)
    {
        return $model->first_name.' '.$model->last_name;
    }
}
```

## Sorting Columns

To allow columns sorting, define the `$sortColumns` array property and add the column ids that should be sorted.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected array $sortColumns = [
        'name', 'email',
    ];
}
```

If you want multiple sorting, define the `$allowMultipleSorting` property and set it's value to true.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected bool $allowMultipleSorting = true;
}
```

Please note that multiple sorting can be a memory intensive task, and it is to be used wisely.

Once the column id matches a table column, the sorting will be handled automatically. However, if the column id does not match a table column, you will have to customize the sorting by defining the `handleSortingQuery` method. It receives an array contain the column ids that has to be sorted, and their sort order.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected function handleSortQuery(array $columns): void
    {
        foreach ($columns as $column => $order) {
            if ($column == 'name') {
                $this->getQuery()->orderBy('first_name', $order);
            } else {
                $this->getQuery()->orderBy(htmlspecialchars($column), $order);
            }
        }
    }
}
```

## Checkbox

If you want a checkbox for each row, change the `$hasCheckbox` property to `true`.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected bool $hasCheckbox = true;
}
```

The default name field that the checkbox content is submitted as is `checkbox`. To change this value, update the `$checkboxName` property with a value of your choice.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected string $checkboxName = 'checkbox_values';
}
```

The value submitted with the checkbox defaults to the model's id field. To change this to something else like uuid, change the `$checkboxIdField`.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected string $checkboxIdField = 'uuid';
}
```

You can determine if a particular row checkbox should be displayed by doing your computation in the `itemHasCheckbox` method.

```php
<?php

namespace App\Tables;

use Illuminate\Support\Facades\Auth;
use Larables\Table;

class UsersTable extends Table
{
    public function itemHasCheckbox(mixed $item): bool
    {
        return Auth::user()->can('destroy', $item);
    }
}
```

## Actions

## Bulk Options

## Per Page Total

## Paginate

## Search

## Active and Trash Sections

## Table Foot

To display the table foot, add the `$displayTfoot` property and set it's value to `true`.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected bool $displayTfoot = true;
}
```