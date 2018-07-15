<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
//        return $this->middleware('auth')->except([
//
//        ]);
    }

    /*
     * 展示某个用户的详情页面
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

}
