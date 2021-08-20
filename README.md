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

Gridbuilder ᵂᴾ Extended permet de déclarer les facettes via des méthodes spécifiques en fonction du type de facette. L'extension d'origine reposant exclusivement sur la base de données, l'outil gère une synchronisation entre ce qui est déclaré côté code et ce qui est présent en base de données (par un hash de modification).

#### Facettes disponibles :

##### Pagination

`PaginationFacet` is used to create a pagination facet.

`AmphiBee\WpgbExtended\Providers\Facets\PaginationFacet`

```
(new PaginationFacet())
    ->disableShowAll()
    ->enableNavigationButton()
    ->enableScrollToTop()
    ->setPrevText('Préc.')
    ->setNextText('Suiv.')
    ->register();
```

**Available methods**

`setPaginationType` : Set the type of pagination  
Arguments : **$value** (Possible values : `numbered`, `prev_next`)

`enableShowAll` : Show all of the pages instead of a short list of the pages near the current page

`disableShowAll` : Disable the show of all of the pages instead of a short list of the pages near the current page

`setMiddlePagesSize` : Set how many numbers to either side of current page, but not including current page.  
Arguments : **$value** Integer

`setEndPagesSize` : Set how many numbers to either side of current page, but not including current page.  
Arguments : **$value** Integer

`setDotText` : Set the text of the dots. Default : …  
Arguments : **$value** String

`enableNavigationButton` : Enable navigation buttons

`disableNavigationButton` : Disable navigation buttons

`setPrevText` : Set the text of the previous button  
Arguments : **$value** String

`setNextText` : Set the text of the next button  
Arguments : **$value** String

`enableScrollToTop` : Enable scroll to top at the change of the page

`disableScrollToTop` : Disable scroll to top at the change of the page

## Content sync

Gridbuilder ᵂᴾ Extended allows you to synchronize all of your content (grids, cards, facets). This is useful when working with multiple environments (local, staging, production).
Like Advanced Custom Fields, the grids, cards, facets are stored in json files. By default, they are stored in your theme folder (`wpgb-json` folder).
You can customize this folder with the `wp_grid_builder/sync/json_folder` filter

It's possible to deactivate the synchronization globally with the filter `wp_grid_builder/enable_sync` or to deactivate it by entity with the filter `wpgb/{$type}/enable_sync` (ex. `wpgb/card/enable_sync`)

*Note: For maps and grids, Gridbuilder ᵂᴾ does not offer a single slug. Gridbuilder ᵂᴾ Extended is based on name by default. It is therefore important to be aware that it will not have to change in the meantime in which case, a duplicate will be created. In the same way, it is important that the name is unique otherwise it will generate conflicts on synchronizations (an alert function will be planned on the next versions)*
