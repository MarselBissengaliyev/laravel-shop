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
        try {
            $validated = $request->validated();

            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'picture_url' => $validated['picture_url'],
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $product,
                'message' => 'product successfully created',
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }

    public function UpdateProductById(UpdateProductRequest $request, int $productId)
    {
        try {
            $validated = $request->validated();

            $product = Product::query()->where('id', $productId)->first();

            if ($product->user_id != auth()->id()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => "you have no right to change someone else's product",
                ], 403);
            }

            $product->update($validated);

            return response()->json([
                'status' => 'success',
                'data' => $product,
                'message' => 'post succefully updated'
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }

    public function DeleteProductById(int $productId)
    {
        try {
            $product = Product::query()->where('id', $productId)->first();

            if ($product->user_id != auth()->id()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => "you have no right to change someone else's product",
                ], 403);
            }

            $product->delete();

            return response()->json('', 204);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }
}
