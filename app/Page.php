<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'content', 'status',
    ];

    /**
     * The categories that the product belongs to.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category')
            ->withTimestamps();
    }

    /**
     * Customizing Route Model Binding
     *
     * @param string $value
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Set the page's slug
     *
     * @param string $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value, '-');
    }

}
