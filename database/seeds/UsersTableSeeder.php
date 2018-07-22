<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        // 头像假数据
        $avatars = [
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png?imageView2/1/w/200/h/200',
        ];

        // 生成数据集合
        $users = factory(User::class)->times(10)->make()
                    ->each(function ($user, $index) use($faker, $avatars){
                        // 从头像数组中随机取出一个并赋值
                        $user->avatar = $faker->randomElement($avatars);
                    });

        // 让隐藏字段可见，并将数据集合转换为数组
        $users_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($users_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'Star';
        $user->email = 'gzstar117@aliyun.com';
        $user->avatar = 'http://www.laravel-study-bbs.com/uploads/images/avatar/201807/22/1_1532250909_kUWgnDDdXP.jpg';
        $user->save();

    }
}