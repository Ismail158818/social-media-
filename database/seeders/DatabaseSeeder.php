<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Group;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. إنشاء الأدوار الأساسية باستخدام الفاكتوري
        \App\Models\Role::factory()->count(4)->create();

        // 1. مستخدمين حسب الدور
        User::factory(4)->create(['image' => 'images/Default_image.jpg', 'role_id' => 1]);
        User::factory(6)->create(['image' => 'images/Default_image.jpg', 'role_id' => 2]);
        User::factory(20)->create(['image' => 'images/Default_image.jpg', 'role_id' => 3]);
        User::factory(30)->create(['image' => 'images/Default_image.jpg', 'role_id' => 4]);

        // 2. مجموعات
        Group::factory(20)->create();

        // 3. إنشاء تاغات وهمية باستخدام الفاكتوري
        Tag::factory(20)->create();

        // 4. منشورات عامة (بدون group_id)
        Post::factory(50)->create(['group_id' => null]);

        // 5. منشورات مجموعات (مع group_id)
        $groups = Group::all();
        foreach ($groups as $group) {
            Post::factory(40)->create([
                'group_id' => $group->id,
                'user_id' => User::inRandomOrder()->first()->id,
            ]);
        }

        // 6. ربط التاغات بالمنشورات (استعمال التاغات الموجودة فقط)
        Post::all()->each(function($post) {
            $tags = Tag::inRandomOrder()->take(rand(1,3))->pluck('id');
            $post->tags()->attach($tags);
        });

        // 7. أعضاء المجموعات مع 3 أدمن في كل مجموعة
        Group::all()->each(function($group) {
            $members = User::inRandomOrder()->take(10)->pluck('id')->toArray();
            shuffle($members);
            $attachData = [];
            foreach ($members as $i => $memberId) {
                $attachData[$memberId] = ['is_admin' => $i < 3 ? 1 : 0]; // أول 3 أدمن
            }
            $group->users()->attach($attachData);
        });

        // 8. متابعات بين الأعضاء
        $users = User::all();
        foreach ($users as $user) {
            $toFollow = $users->where('id', '!=', $user->id)->random(rand(3, 10));
            $user->followings()->attach($toFollow);
        }

        // 9. تعليقات وردود
        Post::all()->each(function($post) {
            $comments = Comment::factory(rand(2, 6))->create([
                'post_id' => $post->id,
            ]);
            // ردود على التعليقات (اختياري)
            /*foreach ($comments as $comment) {
                Comment::factory(rand(1, 3))->create([
                    'post_id' => $post->id,
                    // إذا عندك parent_id للردود أضف هنا
                ]);
            }*/
        });

        // 10. تفاعل (Upvote/Downvote)
        foreach (Post::all() as $post) {
            $voters = User::inRandomOrder()->take(rand(2, 10));
            foreach ($voters as $user) {
                $type = rand(0,1) ? 'upVote' : 'downVote';
                $post->usersRatings()->attach($user->id, ['type' => $type]);
            }
        }
    }
}
