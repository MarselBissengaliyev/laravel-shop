<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function GetProducts()
    {
        try {
            $products = Product::all();

            return response()->json([
                'status' => 'success',
                'products' => $products,
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }

    public function GetMyProducts()
    {
        try {
            $products = Product::query()->where('user_id', auth()->id())->get();

            return response()->json([
                'status' => 'success',
                'data' => $products,
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }

    public function CreateProduct(CreateProductRequest $request)
    {
        $validated = $request->validated();

        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'picture_url' => $validated['picture_url'],
            'user_id' => auth()->id()
        ]);

        return redirect()->route('admin.index')->with('message', 'Product created successfully');
    }

    public function UpdateProductById(UpdateProductRequest $request, int $productId)
    {
        $validated = $request->validated();

        $product = Product::query()->where('id', $productId)->first();

        if ($product->user_id != auth()->id()) {
            return redirect()->route('admin.index')->withErrors('message', "you have no right to delete someone else's product");
        }

        $product->update($validated);

        return redirect()->route('admin.index')->with('message', "you update product succefully");
    }

    public function DeleteProductById(int $productId)
    {
        $product = Product::query()->where('id', $productId)->first();

        if ($product->user_id != auth()->id()) {
            return redirect()->route('admin.index')->withErrors('message', "you have no right to change someone else's product");
        }

        $product->delete();

        return redirect()->route('admin.index')->with('message', "you delete product succefully");
    }
}
