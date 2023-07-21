<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\ProfileSetup;

class AdminController extends Controller
{
    public function users()
    {
        $user = User::with('ProfileSetup')->where("id", "!=", Auth::user()->id)->get();
                
        return view('content.users',compact('user'));
    }
}
