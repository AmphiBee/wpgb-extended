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

### Improved facet rendering

Facets have the slug class make you more powerful styling !

Note : by default, class are only added when `wpgb_render_facet` is called by slug. If you want to enable it when a facet is called by ID, you need to enable it with this filter :

```
add_filter('wpgb_extended/enable_facet_class_from_db', '__return_true');
```

###  Registering facets

@TODO

## Content sync

Gridbuilder ᵂᴾ Extended allows you to synchronize all of your content (grids, cards, facets). This is useful when working with multiple environments (local, staging, production).
Like Advanced Custom Fields, the grids, cards, facets are stored in json files. By default, they are stored in your theme folder (`wpgb-json` folder).
You can customize this folder with the `wpgb_extended/sync/json_folder` filter

It's possible to deactivate the synchronization globally with the filter `wp_grid_builder/enable_sync` or to deactivate it by entity with the filter `wpgb/{$type}/enable_sync` (ex. `wpgb/card/enable_sync`)

*Note: For maps and grids, Gridbuilder ᵂᴾ does not offer a single slug. Gridbuilder ᵂᴾ Extended is based on name by default. It is therefore important to be aware that it will not have to change in the meantime in which case, a duplicate will be created. In the same way, it is important that the name is unique otherwise it will generate conflicts on synchronizations (an alert function will be planned on the next versions)*
