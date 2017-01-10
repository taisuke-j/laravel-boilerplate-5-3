<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'description', 'stock',
    ];

    /**
     * The categories that the product belongs to.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category')
            ->withTimestamps();
    }

}
