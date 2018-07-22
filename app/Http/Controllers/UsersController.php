<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth')->except([
            'show'
        ]);
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
        //授权认证
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * 执行某个用户的信息修改
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        //授权认证
        $this->authorize('update', $user);

        $data = $request->all();
        $old = $user->avatar;   //旧图片, 用于修改后删除原来的图片

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatar', $user->id, 333);
            if ($result) {
                $data['avatar'] = $result['path'];

                //删除旧的图片
                $img = explode(config('app.url'), $old)[1];
                $old_img_real_path = public_path() . $img;
                exec('rm -f ' . $old_img_real_path);
            }
        }

        $user->update($data);

        return redirect()->route('users.show', $user->id)->with('success', '更新个人信息成功');
    }

}
