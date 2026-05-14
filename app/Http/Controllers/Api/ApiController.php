<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * ApiController
 *
 * Stateless JSON API for the mobile application.
 * No session usage — cart management is handled client-side.
 */
class ApiController extends Controller
{
    /**
     * GET /api/categories
     * Returns all categories with their menu items.
     */
    public function categories(): JsonResponse
    {
        $categories = Category::with('menus')->get()->map(function ($cat) {
            return [
                'id'    => $cat->id,
                'name'  => $cat->name,
                'items' => $cat->menus->map(fn($m) => [
                    'id'    => $m->id,
                    'name'  => $m->name,
                    'price' => (float) $m->price,
                    'img'   => $m->img,
                    'desc'  => $m->desc,
                ]),
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $categories,
        ]);
    }

    /**
     * GET /api/menu
     * Returns all menu items as a flat list.
     */
    public function menu(): JsonResponse
    {
        $items = Menu::with('category')->get()->map(fn($m) => [
            'id'       => $m->id,
            'name'     => $m->name,
            'price'    => (float) $m->price,
            'img'      => $m->img,
            'desc'     => $m->desc,
            'category' => $m->category?->name,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $items,
        ]);
    }

    /**
     * POST /api/upload-image
     * Uploads an image and returns the public URL.
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('menu_images', $filename, 'public');
            
            return response()->json([
                'success' => true,
                'url'     => $request->getSchemeAndHttpHost() . '/storage/' . $path,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Yükleme başarısız.'], 400);
    }

    /**
     * POST /api/sync-state
     * Syncs the frontend state (categories and products) to the database.
     */
    public function syncState(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'products'   => 'required|array',
        ]);

        // 1. Sync Categories
        foreach ($validated['categories'] as $catName) {
            Category::firstOrCreate(['name' => $catName]);
        }
        // Optional: Remove categories not in the list? Let's keep them for now.

        // 2. Sync Products
        foreach ($validated['products'] as $p) {
            $category = Category::where('name', $p['category'])->first();
            if (!$category) {
                $category = Category::create(['name' => $p['category']]);
            }

            // If product has a numeric ID from state.js, try to find it. 
            // Otherwise match by name within category.
            $query = Menu::where('name', $p['name'])->where('category_id', $category->id);
            
            $menu = $query->first();

            if ($menu) {
                $menu->update([
                    'price' => $p['price'],
                    'img'   => $p['img'],
                    'desc'  => $p['desc'] ?? '',
                ]);
            } else {
                Menu::create([
                    'name'        => $p['name'],
                    'category_id' => $category->id,
                    'price'       => $p['price'],
                    'img'         => $p['img'],
                    'desc'        => $p['desc'] ?? '',
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Sistem durumu başarıyla senkronize edildi.',
        ]);
    }

    /**
     * GET /api/orders
     * Returns all orders with their items.
     */
    public function listOrders(): JsonResponse
    {
        $orders = Order::with('items')->latest()->get()->map(fn($o) => [
            'id'         => $o->id,
            'total'      => (float) $o->total,
            'created_at' => $o->created_at?->toIso8601String(),
            'items'      => $o->items->map(fn($i) => [
                'name'     => $i->name,
                'price'    => (float) $i->price,
                'quantity' => $i->quantity,
            ]),
        ]);

        return response()->json([
            'success' => true,
            'data'    => $orders,
        ]);
    }

    /**
     * GET /api/orders/{id}
     * Returns a single order with its items.
     */
    public function showOrder(int $id): JsonResponse
    {
        $order = Order::with('items')->find($id);

        if (! $order) {
            return response()->json(['success' => false, 'message' => 'Sipariş bulunamadı.'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'id'         => $order->id,
                'total'      => (float) $order->total,
                'created_at' => $order->created_at?->toIso8601String(),
                'items'      => $order->items->map(fn($i) => [
                    'name'     => $i->name,
                    'price'    => (float) $i->price,
                    'quantity' => $i->quantity,
                ]),
            ],
        ]);
    }

    /**
     * POST /api/orders
     * Creates a new order from a JSON body.
     *
     * Expected body:
     * {
     *   "items": [
     *     { "name": "Köfte", "price": 75.00, "quantity": 2 },
     *     ...
     *   ]
     * }
     */
    public function createOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items'              => 'required|array|min:1',
            'items.*.name'       => 'required|string|max:255',
            'items.*.price'      => 'required|numeric|min:0',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        $total = collect($validated['items'])->sum(
            fn($i) => $i['price'] * $i['quantity']
        );

        $order = Order::create(['total' => $total]);

        foreach ($validated['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'name'     => $item['name'],
                'price'    => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sipariş başarıyla oluşturuldu.',
            'data'    => [
                'order_id' => $order->id,
                'total'    => (float) $total,
            ],
        ], 201);
    }

    /**
     * GET /api/env-check
     * Returns runtime environment info for the Vercel diagnostic page.
     */
    public function envCheck(): JsonResponse
    {
        return response()->json([
            'success'        => true,
            'php_version'    => PHP_VERSION,
            'app_env'        => env('APP_ENV', 'unknown'),
            'app_debug'      => env('APP_DEBUG', 'unknown'),
            'cache_driver'   => env('CACHE_DRIVER', 'unknown'),
            'session_driver' => env('SESSION_DRIVER', 'unknown'),
            'log_channel'    => env('LOG_CHANNEL', 'unknown'),
            'db_connection'  => env('DB_CONNECTION', 'unknown'),
            'server_time'    => now()->toIso8601String(),
        ]);
    }
}
