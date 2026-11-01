# Larables

- [About](#About)
- [Installation](#Installation)
- [Setup](#Setup)
- [Getting Started](#Getting-Started)
- Actions
    - [Enabling Actions](#Enabling-Actions)
    - [Defining Actions](#Defining-Actions)
    - [Actions Column Title](#Actions-Column-Title)
    - [Row Actions](#Row-Actions)
    - [Supported Actions](#Supported-Actions)

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

You will also need a data source to work, in this care, from the database. Define a `baseQuery` method on your table class. This method should return an instance of the Eloquent Builder. DO NOT do the following, as they are either handled by the package or will be covered later on:

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

## Enabling Actions

To enable actions, set the `hasActions` property to `true`.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected bool $hasActions = true;
}
```

## Defining Actions

To define actions, add key value pairs to the `actions` array property. The key will be the action id while the array value will contain details to construct and process the action as shown below.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected array $actions = [
        'edit' => [
            'route' => 'https://home.com',
            'route_name' => 'home',
            'args' => ['animal' => 'dog', 'breed' => 'german_shepherd'],
            'pass_model' => true,
        ],
    ];
}
```

`route` - The explicit url to go to when the action is clicked. No other information passed will be processed.

`route_name` - The route name to generate the url for when the action is clicked on.

`args` - An array of query args to pass to the route name. 

`pass_model` - If to pass the model to the route name. This defaults to false. If defined as true, it will only be passed when the `args` key is empty.

## Action Content Type

Your action content type can be `text` or `icon`. To define which you prefer, specify on the `$actionDisplayType` property.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected string $actionContentType = 'text'; // also accepts icon
}
```

## Action Display Type

You can also configure if you want your action wrapped in a link or button. Set your preference on the `$actionDisplayType` property.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    protected string $actionDisplayType = 'text'; // also accepts icon
}
```

## Actions Column Title

If you want the actions column title to display a name, add the `getActionsColumnTitle` method to your class and return the title you wish to use.

```php
<?php

namespace App\Tables;

use Larables\Table;

class UsersTable extends Table
{
    /**
     * Get the actions column title.
     */
    public function getActionsColumnTitle(): string
    {
        return 'Actions';
    }
}
```

## Row Actions

Sometimes you may not want to show action for certain rows, for example, trash action for a super admin. To do this, simply call the `getItemActions` method and do your filtering.

```php
<?php

// ...

class UsersTable extends Table
{
    public function getItemActions(mixed $item): array
    {
        // No actions for super admin
        if (Auth::user()->isSuperAdmin()) {
            return [];
        }

        // Otherwise show all actions defined
        return $this->getActions();
    }
}
```

## Supported Actions

Actions supported by default are `edit`, `view`, `trash`, `restore` and `destroy`. This means once you supply any of these are the action ids, an appropriate icon is already configured. No stress if you choose another action type, you can return the icon to use as a string to a dynamic method.

```php
<?php

// ...

class UsersTable extends Table
{
    /**
     * Get the download action icon markup.
     */
    public function getDownloadActionIconHtml(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M17 17H17.01M17.4 14H18C18.9319 14 19.3978 14 19.7654 14.1522C20.2554 14.3552 20.6448 14.7446 20.8478 15.2346C21 15.6022 21 16.0681 21 17C21 17.9319 21 18.3978 20.8478 18.7654C20.6448 19.2554 20.2554 19.6448 19.7654 19.8478C19.3978 20 18.9319 20 18 20H6C5.06812 20 4.60218 20 4.23463 19.8478C3.74458 19.6448 3.35523 19.2554 3.15224 18.7654C3 18.3978 3 17.9319 3 17C3 16.0681 3 15.6022 3.15224 15.2346C3.35523 14.7446 3.74458 14.3552 4.23463 14.1522C4.60218 14 5.06812 14 6 14H6.6M12 15V4M12 15L9 12M12 15L15 12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>';
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