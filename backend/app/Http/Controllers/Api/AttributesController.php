<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attribute as ModelsAttribute;
use Illuminate\Http\Request;

class AttributesController extends Controller
{
    public function index($category_id)
    {
        $attributes = ModelsAttribute::where('category_id', $category_id)->get();

        return $attributes;
    }
}
