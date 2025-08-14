<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'pict_url',
        'brand_name',
        'building',
        'price',
        'detail',
        'condition',
        'sold',
    ];

    public function favorites()
    {
        return $this->hasMany('App\Models\Favorite');
    }

    public function scopeNameSearch($query, $search)
    {
        if (!empty($search)) {
        $query->where('name', 'like', '%' . $search . '%');
        }
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_item');
    }

}
