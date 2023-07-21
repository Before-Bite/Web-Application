<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foods;
use App\Models\FoodCategory;

class FoodController extends Controller
{
    public function index()
    {
        $Foods = Foods::with('FoodCategory')->get();
        $FoodCategorys = FoodCategory::all();
        return view('content.food.index', compact('Foods','FoodCategorys'));
    }
    public function create()
    {
        $FoodCategorys = FoodCategory::all();
        return view('content.food.create', compact('FoodCategorys'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_category' => 'required',
            'name' => 'required',
        ]);

        if($request->id)
        {
            $Foods = Foods::where('id',$request->id)->update([
                'category_id' => $request->food_category,
                'food_name' => $request->name,
            ]);
        }
        else{
            $Foods = Foods::create([
                'category_id' => $request->food_category,
                'food_name' => $request->name,
            ]);
        }
        return redirect()->route('Foods');
    }
    public function delete($id)
    {
        $Food = Foods::find($id);
        $Food->delete();
        return redirect()->route('Foods');
    }
}
