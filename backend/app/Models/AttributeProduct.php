<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeProduct extends Model
{
    use HasFactory;

    protected $appends = [ 'attribute' ];

    protected $fillable = [
        'attribute_id',
        'product_id',
        'value',
    ];

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'id', 'attribute_id');
    }

    public function getAttributeAttribute()
    {
        return $this->attribute()->first()->name;
    }
}
