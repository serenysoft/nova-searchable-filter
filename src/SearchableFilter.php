<?php

namespace Sereny\NovaSearchableFilter;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class SearchableFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'searchable-filter';

    /**
     * The attribute name used in where condition
     *
     * @var string
     */
    public $attribute;

    /**
     * Create a new filter.
     *
     * @param  string  $name
     * @param  string  $relation
     * @param  string  $attribute
     */
    public function __construct($name, $relation, $attribute = null)
    {
       $this->name = $name;
       $this->attribute = $attribute ?: Str::snake($relation) . '_id';
       $this->withMeta(['relation' => $relation]);
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $selected)
    {
        return $query->where($this->attribute, $selected['value']);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [];
    }

    /**
     *
     * @return this
     */
    public function withSubtitles($value = true)
    {
        $this->withMeta(['withSubtitles' => $value]);

        return $this;
    }

    /**
     * Get the key for the filter.
     *
     * @return string
     */
    public function key()
    {
        return get_class($this) . '\\' . ucfirst($this->attribute);
    }
}
