<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends = [ 'category', 'attributes' ];

    protected $fillable = [
                            'category_id',
                            'name',
                            'sku',
                            'brand',
                            'price',
                            'stock',
                        ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function getCategoryAttribute()
    {
        return $this->category()->first()->name;
    }

    public function getAttributesAttribute()
    {
        return AttributeProduct::where('product_id', $this->id)
                               ->get()
                               ->toArray();
    }

}
