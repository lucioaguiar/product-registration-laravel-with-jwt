<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $products = Auth::user()->products;
        return response()->json($products);
    }

    public function upload(Request $request){

        $image = null;
        if($request->hasFile('image')) {
            $result = ImageHelper::saveResize($request->file('image'));
            $image = json_decode($result);
            $image = asset('storage/uploads/' . $image->path) . '/' . $image->name;
        }
        return response()->json([
            'url' => $image
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'image' => $request->image,
        ]);

        return $product;
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json([
            'status' => 'success',
            'product' => $product,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = $request->image;
        $product->save();

        return $product;
    }

    public function destroy($id)
    {

        $product = Product::find($id);
        $product->delete();

        return $product;
    }

}
