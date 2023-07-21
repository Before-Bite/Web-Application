<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurent;

class PostController extends Controller
{
    public function index()
    {
        $post = Restaurent::get();
        return view('content.resturantsPost.index',compact('post'));
    }

    public function edit_post(Request $request)
    {
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $image = date('YmdHi') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profileImages'), $image);
            
            $Restaurent = Restaurent::where('id',$request->id)->update([
                'dish_picture' => 'profileImages/' . $image,
            ]);
        }

        $Restaurent = Restaurent::where('id',$request->id)->update([
            'review' => $request->review,
        ]);

        return back()->with('success', 'Post Edit Successfully');
    }
    
    public function delete($id)
    {
        $Restaurent = Restaurent::find($id);
        $Restaurent->delete();
        return redirect()->route('post');
    }
}
