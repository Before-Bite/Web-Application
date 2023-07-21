<?php

namespace App\Http\Controllers;

use App\Models\FoodCategory;
use App\Models\Foods;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfileSetup;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $foodArray = [];
        $FoodCategory = FoodCategory::select('food_category_name','id')->get();

        foreach($FoodCategory as $FoodCategorys){
            $Foods[] = Foods::where('category_id',$FoodCategorys->id)->count();
            $foodArray = $Foods;    
        }

        $MaleUser = ProfileSetup::select('user_id')->where('gender','male')->get();
        $MaleUsers = User::whereIn('id',$MaleUser)->count();

        $FemaleUser = ProfileSetup::select('user_id')->where('gender','female')->get();
        $FemaleUsers = User::whereIn('id',$FemaleUser)->count();

        return view('content.home',compact('FoodCategory','foodArray','MaleUsers','FemaleUsers'));
    }
}
