<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodCategory;

class CategoryController extends Controller
{
    public function category()
    {
        $FoodCategory = FoodCategory::orderBy('created_at','desc')->get();
        return view('content.category.food-category', compact('FoodCategory'));
    }

    public function add_food_category()
    {
        return view('content.category.add-food-category');
    }

    public function add_category_to_db(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image = date('YmdHi') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profileImages'), $image);
        }

        if($request->id)
        {
            $FoodCategory = FoodCategory::where('id',$request->id)->update([
                'food_category_name' => $request->name,
                'images' => 'profileImages/' . $image,
            ]);
        }
        else
        {
            $FoodCategory = FoodCategory::create([
                'food_category_name' => $request->name,
                'images' => 'profileImages/' . $image,
            ]);
        }
        return redirect()->route('category');
    }

    public function deleteFoodCategory($id)
    {
        $FoodCategory = FoodCategory::find($id);
        $FoodCategory->delete();
        return redirect()->route('category');
    }
}
