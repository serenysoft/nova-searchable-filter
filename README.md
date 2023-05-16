# Nova Searchable Filter

Laravel Nova Searchable filter for belongsTo relationships.

### Installation

`composer require sereny/nova-searchable-filter`

### Usage

For this example let's assume a user belongs to a department.
To make the relationship searchable via a filter, add this to the `filters()` function of your Nova user resource:

You need set first and second argument, which define the filter title and the relation name.
The final argument defines the attribute name to be used in the `WHERE` condition.

```php
// app/Nova/User.php

use Sereny\NovaSearchableFilter\SearchableFilter

/**
 * Get the filters available for the resource.
 *
 * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
 * @return array
 */
public function filters(Request $request)
{
    return [
        SearchableFilter::make(__('Departament'), 'department')
    ];
}
```
