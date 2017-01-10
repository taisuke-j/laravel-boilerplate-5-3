<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'type',
    ];

    /**
     * Associated models list
     *
     * @var array
     */
    protected $models = [
        'product', 'post',
    ];

    /**
     * The products under the category
     */
    public function products()
    {
        return $this->belongsToMany('App\Product')
            ->withTimestamps();
    }

    /**
     * Check if the model has categories
     * @param string $slug
     * @param boolean $is_valid
     */
    public function validModel($model)
    {

        $is_valid = false;
        foreach ($this->models as $valid_model) {
            if ($model === $valid_model) {
                $validation = true;
                break;
            }
        }
        return $is_valid;
    }

    /**
     * Set the category's slug
     *
     * @param string $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value, '-');
    }
    
}
