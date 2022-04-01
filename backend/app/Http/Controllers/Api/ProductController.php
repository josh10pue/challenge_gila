<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttributeProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return $products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'sku' => 'required',
            'brand' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'attribute_1' => 'required|exists:attributes,id',
            'attribute_1_value' => 'required',
            'attribute_2' => 'required|exists:attributes,id',
            'attribute_2_value' => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode([
                                'status' => '503',
                                'message' => $validator->errors()
                               ]);
        }


        $product = new Product();
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->brand = $request->brand;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();

        $this->saveProductAttribute( $request->attribute_1, $product->id, $request->attribute_1_value);
        $this->saveProductAttribute( $request->attribute_2, $product->id, $request->attribute_2_value);

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'sku' => 'required',
            'brand' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'attribute_1' => 'required|exists:attributes,id',
            'attribute_1_value' => 'required',
            'attribute_2' => 'required|exists:attributes,id',
            'attribute_2_value' => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode([
                                'status' => '503',
                                'message' => $validator->errors()
                               ]);
        }

        $product = Product::findOrFail($id);

        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->brand = $request->brand;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();

        $this->updateProductAttribute( $request->attribute_1, $id, $request->attribute_1_value);
        $this->updateProductAttribute( $request->attribute_2, $id, $request->attribute_2_value);

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $attributesModel = AttributeProduct::select('id')->where('product_id', $id)->get();

        $attributesIds = $attributesModel->map(function ($item, $key) {
            return $item->id;
        });

        AttributeProduct::destroy($attributesIds);

        $product->delete();

        return $product;
    }

    function saveProductAttribute($attribute_id, $product_id, $value)
    {
        $attribute = new AttributeProduct();
        $attribute->attribute_id = $attribute_id;
        $attribute->product_id = $product_id;
        $attribute->value = $value;
        $attribute->save();

        return;
    }

    function updateProductAttribute($attribute_id, $product_id, $value)
    {
        // $attribute = AttributeProduct::where('product_id', $product_id)
        //                              ->where('attribute_id', $attribute_id)
        //                              ->first();

        // $attribute->value = $value;
        // $attribute->save();

        return ;
    }
}
