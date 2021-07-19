# An object-oriented package for WordPress hooks.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/digitalbitdev/hooks.svg?style=flat-square)](https://packagist.org/packages/digitalbitdev/hooks)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/digitalbitdev/hooks/run-tests?label=tests)](https://github.com/digitalbitdev/hooks/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/digitalbitdev/hooks.svg?style=flat-square)](https://packagist.org/packages/digitalbitdev/hooks)


This package provides an object-oriented API for use with the WordPress [Plugin API](https://codex.wordpress.org/Plugin_API). The package also includes automatic "number of arguments" calculation and chainable callbacks.

## Installation

You can install the package via composer:

```bash
composer require amphibee/hookable
```

## Usage

There is a dedicated class for each type of ["hook"](https://developer.wordpress.org/plugins/hooks/).

### Actions

To interact with actions, you need to use the `\AmphiBee\Hooks\Action` class.

**Registering actions**:

To register an action, call the `Action::add()` method. This method takes **3 arguments**:

```php
use AmphiBee\Hooks\Action;

Action::add($name, $callback, $priority);
```

You do not need to provide the number of parameters that the callback takes. This is automatically resolved using the [Reflection API](https://www.php.net/manual/en/book.reflection.php).

**Chained callbacks**:

It is possible to provide extra callbacks that run **after** your initial callback. For example, you may wish to call one of your application helpers to do something extra.

```php
use AmphiBee\Hooks\Action;

Action::add('init', function () {
    // do something here...
})->then([MyPlugin::class, 'checkUserIsAdmin']);
```

The chained callbacks will receive the **return value** and all arguments that the initial callback received.

```php
class MyPlugin
{
    public static function checkUserIsAdmin($resultFromInitialCallback, ...$extraArgs)
    {
        // ...
    }
}
```

**Running actions**:

You can fire / run an action using the `Action::do()` method, as well as pass in arguments just like you would with `do_action`.

```php
use AmphiBee\Hooks\Action;

Action::do('my_plugin_action', $argument, $another);
```

**Removing actions**:

To remove an action, use the `Action::remove()` method:

```php
use AmphiBee\Hooks\Action;

Action::remove('init', $callbackToRemove, $priority);
```

### Filters

To interact with filters, you need to use the `\AmphiBee\Hooks\Filter` class.

**Registering filters**:

To register a filter, use the `Filter::add()` method:

```php
use AmphiBee\Hooks\Filter;

Filter::add('the_title', function ($title) {
    return $title . ' is the title.';
});
```

**Chained callbacks**:

It is possible to provide extra callbacks that run **after** your initial callback. For example, you may wish to call one of your application helpers to do something extra.

```php
use AmphiBee\Hooks\Filter;

Filter::add('the_title', function ($title) {
    return $title . ' is the title.';
})->then('strtoupper');
```

The chained callbacks will behave the same way as actions and will receive the **return value** of the initial callback and then any arguments that were passed to the initial callback.

The example above will pass the return value of `$title . ' is the title'` to the `strtoupper` method.

**Applying filters**:

You can apply filters using the `Filter::do()` or `Filter::apply()` methods (`Filter::apply()` is an alias of `Filter::do()`). These behave in the same way as the `Action::do()` method and take the same arguments.

```php
use AmphiBee\Hooks\Filter;

$title = Filter::do('the_title', 'Hello, World!');

// or..
$title = Filter::apply('the_title', 'Hello, World!');
```

**Removing filters**:

You can remove filters using the `Filter::remove()` method. This behaves the same as the `Action::remove()` method and both use the same underlying logic.

```php
$callback = function () {

};

// logic here...

Filter::remove('the_title', $callback);
```

### Hookable classes

This package provides a convenient `Hookable` interface that can be used to register single-use class callbacks.

```php
use AmphiBee\Hooks\Contracts\Hookable;

class InitAction implements Hookable
{
    public function execute()
    {
        // ...
    }
}

Action::add('init', InitAction::class);
```

**Receiving hook arguments**:

To receive the arguments passed from the caller, define a constructor on your class and assign them to properties:

```php
use AmphiBee\Hooks\Contracts\Hookable;

class TheTitleFilter implements Hookable
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function execute()
    {
        if ($this->title !== 'My First Post') {
            return $this->title;
        }

        return "{$this->title} is Amazing!";
    }
}

Filter::add('the_title', TheTitleFilter::class);
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email ryan@digitalbit.dev instead of using the issue tracker.

## Credits

- [Ryan Chandler](https://github.com/ryangjchandler)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
