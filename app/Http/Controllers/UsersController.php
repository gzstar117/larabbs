<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

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

    /*
     * 展示某个用户的编辑页面
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * 执行某个用户的信息修改
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('users.show', $user->id)->with('success', '更新个人信息成功');
    }

}
