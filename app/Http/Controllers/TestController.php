<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $categories = Category::with('menus')->get();

        return view('test', compact('categories'));
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect('/test');
    }
    public function edit($id)
{
    $category = Category::find($id);
    return view('edit', compact('category'));
}

public function update(Request $request, $id)
{
    $category = Category::find($id);
    $category->name = $request->name;
    $category->save();

    return redirect('/test');
}
public function storeMenu(Request $request)
{
    Menu::create([
        'name' => $request->name,
        'category_id' => $request->category_id
    ]);

    return redirect('/test');
}
    
}