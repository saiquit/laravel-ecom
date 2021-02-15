<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::query();
        if ($request->get('productName')) {
            $products->where('title', 'LIKE', "%" . $request['productName'] . "%");
        }
        if ($request->get('category')) {
            $products->whereIn('category', $request['category']);
        }

        return $products->with(['category'])->paginate(12);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'string',
            'price' => 'integer',
            'description' => 'string',
            'stock' => 'integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'category_id' => 'integer'
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $image = $request->image->storeAs('images', $imageName);
        return $product->create([
            'title' => $request['title'],
            'price' => $request['price'],
            'description' => $request['description'],
            'stock' => $request['stock'],
            'image' => 'storage/' . $image,
            'category_id' => $request['category_id']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, $id)
    {
        return $product->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, $id)
    {
        $foundProduct = $product->findOrFail($id);

        $request->validate([
            'title' => 'string',
            'price' => 'integer',
            'description' => 'string',
            'stock' => 'integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'category_id' => 'integer'
        ]);

        $image_path = $foundProduct['image'];  // Value is not URL but directory file path
        if (Storage::exists($image_path)) {
            Storage::delete($image_path);
        }

        $imageName = time() . '.' . $request->image->extension();
        $image = $request->image->storeAs('images', $imageName);
        $foundProduct->update([
            'title' => $request['title'],
            'price' => $request['price'],
            'description' => $request['description'],
            'stock' => $request['stock'],
            'image' => $image,
            'category_id' => $request['category_id']
        ]);

        return response()->json([
            'message' => 'successfully updated'
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id)
    {
        $product->findOrFail($id)->delete();
        return response()->json([
            'message' => "Successfully delete"
        ]);
    }
}
