<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    /**
     * todo 笔记
     * 关联模型, 方法名最好是用"对应模型名的单数形式", 这样, 在填写类似belongsTo这种关联方法时,可以不用传第二个参数(外键), 因为Laravel会自动根据 "模型名_id" 作为外键, 去查找对应的关联数据
     */

    public function user()
    {
        //由于关联函数是用"user"做为函数名, 因此第二参数不用传也可以, 默认在Topic模型里面找user_id作为外键
        return $this->belongsTo(User::class);
    }

    public function findCategory()
    {
        //由于关联函数"不是以模型名的单数"作为函数名, 因此传递第二个参数, 来指定外键(category_id)
        return $this->belongsTo(Category::class, 'category_id');
    }
}
