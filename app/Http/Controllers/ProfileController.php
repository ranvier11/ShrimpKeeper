<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class ProfileController extends Controller
{
    //
    public function index($user)
    {
        $user = User::findOrFail($user);
        //$tanks = $user->tanks();
        return view('home', [
            'user' => $user

        ]);
    }
}
