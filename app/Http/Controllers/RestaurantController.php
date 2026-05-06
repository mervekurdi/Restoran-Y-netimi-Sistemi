<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;

class RestaurantController extends Controller
{
   
    public function home()
    {
        return view('welcome');
    }


    public function menu()
    {
        $categories = Category::with('menus')->get();

        return view('menu', compact('categories'));
    }

    
    public function cart()
    {
        return view('cart');
    }

    
    public function orders()
    {
        $orders = Order::with('items')->get();

        return view('orders', compact('orders'));
    }
    public function addToCart($id)
{
    $menu = Menu::findOrFail($id);

    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $menu->name,
            "price" => $menu->price,
            "quantity" => 1
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back();
}
public function removeFromCart($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
    }

    session()->put('cart', $cart);

    return redirect()->back();
}

public function increase($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    }

    session()->put('cart', $cart);

    return redirect()->back();
}

public function decrease($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        if ($cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        } else {
            unset($cart[$id]);
        }
    }

    session()->put('cart', $cart);

    return redirect()->back();
}
public function confirmOrder()
{
    $cart = session()->get('cart', []);

    if (count($cart) == 0) {
        return redirect()->back();
    }

    $total = collect($cart)->sum(function($item){
        return $item['price'] * $item['quantity'];
    });

    $order = Order::create([
        'total' => $total
    ]);

    foreach ($cart as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'name' => $item['name'],
            'price' => $item['price'],
            'quantity' => $item['quantity']
        ]);
    }

    session()->forget('cart');

    return redirect('/orders');
}
}