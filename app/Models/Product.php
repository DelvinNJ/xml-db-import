<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'entity_id',
        'category_name',
        'sku',
        'name',
        'description',
        'short_desc',
        'price',
        'link',
        'image',
        'brand',
        'rating',
        'caffeine_type',
        'count',
        'flavored',
        'seasonal',
        'in_stock',
        'facebook',
        'is_kcup'
    ];

    protected $casts = [
        'flavored' => 'boolean',
        'seasonal' => 'boolean',
        'in_stock' => 'boolean',
        'facebook' => 'boolean',
        'is_kcup' => 'boolean',
    ];


    public function setFlavoredAttribute($value)
    {
        $this->attributes['flavored'] = strtolower($value) == 'yes' ? true : false;
    }
    public function setSeasonalAttribute($value)
    {
        $this->attributes['seasonal'] = strtolower($value) == 'yes' ? true : false;
    }
    public function setInStockAttribute($value)
    {
        $this->attributes['in_stock'] = strtolower($value) == 'yes' ? true : false;
    }
    public function setFacebookAttribute($value)
    {
        $this->attributes['facebook'] = $value == 1 ? true : false;
    }
    public function setIsKcupAttribute($value)
    {
        $this->attributes['is_kcup'] = $value == 1 ? true : false;
    }


    public function getFlavoredAttribute($value)
    {
        return $value ? 'Yes' : 'No';
    }
    public function getSeasonalAttribute($value)
    {
        return $value ? 'Yes' : 'No';
    }
    public function getInStockAttribute($value)
    {
        return $value ? 'Yes' : 'No';
    }
    public function getFacebookAttribute($value)
    {
        return $value ? '1' : '';
    }
    public function getIsKcupAttribute($value)
    {
        return $value ? '1' : '';
    }
}
