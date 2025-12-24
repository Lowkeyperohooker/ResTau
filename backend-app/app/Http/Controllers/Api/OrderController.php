<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|exists:menu_items,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric',
        ]);

        try {
            // 2. Start a Database Transaction (Safety Net)
            DB::beginTransaction();

            // 3. Create the Main Order
            // We hardcode user_id = 1 for now since we have no login
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => 1, 
                'status' => 'COMPLETED',
                'total_amount' => $request->total,
                'created_at' => now(),
            ]);

            // 4. Create the Order Items (The loop)
            $orderItems = [];
            foreach ($validated['cart'] as $item) {
                $orderItems[] = [
                    'order_id' => $orderId,
                    'menu_item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price_at_order' => $item['price'],
                ];
            }

            // Bulk insert all items at once for speed
            DB::table('order_items')->insert($orderItems);

            // 5. Commit (Save everything)
            DB::commit();

            return response()->json(['message' => 'Order saved!', 'order_id' => $orderId], 201);

        } catch (\Exception $e) {
            // If anything goes wrong, undo changes
            DB::rollBack();
            return response()->json(['error' => 'Order failed: ' . $e->getMessage()], 500);
        }
    }
}