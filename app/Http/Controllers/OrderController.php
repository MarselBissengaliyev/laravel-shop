<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeOrderStatusRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderController extends Controller
{
    //
    public function GetMyOrders()
    {
        try {
            $orders = Order::query()->where('user_id', auth()->id());

            return response()->json([
                'stauts' => 'success',
                'data' => $orders
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }

    public function ChangeOrderStatus(ChangeOrderStatusRequest $request, int $orderId)
    {
        try {
            $validated = $request->validated();

            $order = Order::query()->where('id', $orderId)->update([
                'status' => $validated['status']
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $order,
                'message' => 'order status succefully updated',
            ]);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }

    public function CreateOrder(CreateOrderRequest $request)
    {
        try {
            $validated = $request->validated();

            $ordersCount = Order::query()->count() + 1;

            $order = Order::create([
                'number' => $ordersCount,
                'status' => 'in_progress',
                'user_id' => auth()->id(),
                'products' => $validated['products']
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $order,
                'message' => 'order succefully creted'
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }

    public function ShowOrdersOfMyProduct(int $productId)
    {
        try {
            $orders = Order::whereJsonContains('products', [['id' => "$productId"]])->get();

            return response()->json([
                'status' => 'success',
                'data' => $orders,
            ], 200);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ], 500));
        }
    }
}
