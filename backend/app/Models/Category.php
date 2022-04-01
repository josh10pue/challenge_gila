<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $appends = [ 'attributes' ];

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'category_id', 'id' );
    }

    public function getAttributesAttribute()
    {
        return $this->attributes()->get()->toArray();
    }

}
