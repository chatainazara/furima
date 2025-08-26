<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Category;

class CategoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'category_id',
    ];
}
