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


    /*
     * todo 笔记
     * 本地作用域
     * 在对应 Eloquent 模型方法前加上一个 scope 前缀, 作用域总是返回 "查询构建器", 也就是下面函数的形参$query, 此参数必需有, 而且一定放在第一位
     * PS: 其实$query也就是指代本模型Topic的一个实例, 用于在查询时链式调用, 注意在调用时, 无需写上scope, 并且$query不需要传递, 只需传第二个参数(若有)
     */
    public function scopeWithOrder($query, $order)
    {
        // 不同的排序, 使用不同的数据读取逻辑
        switch ($order) {
            case 'recent' :
                $query->recent();   //此处的recent(), 就是本模型中的本地作用域函数 scopeRecent(), 可看出调用时, 无需写上scope, 并且$query不需要传递
                break;

            default :
                $query->recentReplied();    //同上, 此处也是调用本地作用域 scopeRecentReplied()
                break;
        }

        // 预加载防止 N+1 问题
        return $query->with('user', 'findCategory');    //作用域总是返回 "查询构建器" $query
    }


    //本地作用域, 调用此函数可获取最近有更新的Topic数据
    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');    //总是返回 "查询构建器" $query
    }


    //本地作用域, 调用此函数可获取最新创建的Topic数据
    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');   //总是返回 "查询构建器" $query
    }


}
