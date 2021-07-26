# Gridbuilder ᵂᴾ Extended

> Register [Gridbuilder ᵂᴾ](https://www.wpgridbuilder.com) with object oriented PHP.

Gridbuilder ᵂᴾ Extended provides an object oriented API to register templates and (soon) facets. If you register template or facets in your theme, you can safely rely on version control when working with other developers.

- [Installation](#installation)
- [Templates](#templates)
- [Facets](#facets)
- [Content sync](#content-sync)

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

### Get facet by slug

You have now the possibility to get facet by slug

```
wpgb_render_facet([
  'slug' => 'pagination',
  'grid' => 'post-list'
])
```

###  Registering facets

@TODO

## Content sync

WPGB Extended allows you to synchronize all of your content (grids, cards, facets). This is useful when working with multiple environments (local, staging, production).
Like Advanced Custom Fields, the facets are stored in json files. By default, they are stored in your theme folder (`wpgb-json` folder).
You can customize this folder with the `wp_grid_builder/sync/json_folder` filter

It's possible to deactivate the synchronization globally with the filter `wp_grid_builder/enable_sync` or to deactivate it by entity with the filter `wpgb/{$type}/enable_sync` (ex. `wpgb/card/enable_sync`)
