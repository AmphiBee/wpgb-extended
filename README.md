# Gridbuilder ᵂᴾ Extended

> Register [Gridbuilder ᵂᴾ](https://www.wpgridbuilder.com) with object oriented PHP.

Gridbuilder ᵂᴾ Extended provides an object oriented API to register templates and (soon) facets. If you register template or facets in your theme, you can safely rely on version control when working with other developers.

- [Installation](#installation)
- [Templates](#templates)
- [Facets](#facets)

## Installation

Require this package, with Composer, in the root directory of your project.

```bash
composer require amphibee/wpgb-extended
```

Download the [Gridbuilder ᵂᴾ](https://wpgridbuilder.com/pricing/) plugin and put it in either the `plugins` or `mu-plugins` directory. Visit the WordPress dashboard and activate the plugin. Please note that this package supports Gridbuilder ᵂᴾ version 1.4 or higher.

## Templates

Use the `Template::make()` function to register a new template. Below you'll find an example of a template registration.

```php
use WpgbExtended\Providers\Template;

Template::make('post-list')
  ->setSourceType('post')
  ->setClasses(['list', 'is-full-width'])
  ->setWrapperTag('ul')
  ->setQueryArgs([
    'post_type'      => 'post',
    'posts_per_page' => 10,
  ])
  ->setRenderCallback('prefix_render_callback')
  ->setNoResultsCallback('prefix_noresults_callback')
  ->register();
```

Visit the official [Gridbuilder ᵂᴾ template documentation](https://docs.wpgridbuilder.com/resources/filter-templates/) to read more about the template settings.

## Facets

@TODO
