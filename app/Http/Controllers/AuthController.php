<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function loginHandle(Request $request) {
        $request->validate([
            'name' => 'required|max:25|string'
        ]);

        $inp = Str::lower($request->name);
        $isAvailable = User::where("name", $inp)->first(); 

        if($isAvailable){
            Auth::login($isAvailable);
            return redirect("/")->with("success", "Selamat datatng kembali!");
        }else{
            $user = new User();
            $user->name = $inp;
            $user->save();
            return redirect("/")->with("success", "Selamat datatng!");
        }


    }
}
