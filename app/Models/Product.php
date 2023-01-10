<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['product_category_id', 'title', 'image', 'image_description', 'created_at', 'updated_at', 'created_by', 'updated_by'];
}
