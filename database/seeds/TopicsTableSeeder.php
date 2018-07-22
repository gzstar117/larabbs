<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        // 所有用户 ID 数组，如：[1,2,3,4]
        $users_ids = User::all()->pluck('id')->toArray();

        // 所有分类 ID 数组，如：[1,2,3,4]
        $categories_ids = Category::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(\Faker\Generator::class);

        $topics = factory(Topic::class)->times(100)->make()
            ->each(function ($topic, $index) use($faker, $users_ids, $categories_ids) {

                // 从 用户ID 和 分类ID 数组中随机取出一个并赋值
                $topic->user_id = $faker->randomElement($users_ids);
                $topic->category_id = $faker->randomElement($categories_ids);
        });

        // 将数据集合转换为数组，并插入到数据库中
        Topic::insert($topics->toArray());
    }

}

