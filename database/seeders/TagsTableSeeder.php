<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $tags = [
            ['tag_name' => 'Laravel', 'user_id' => 1],
            ['tag_name' => 'ASP', 'user_id' => 1],
            ['tag_name' => 'C#', 'user_id' => 1],
            ['tag_name' => 'C++', 'user_id' => 1],
            ['tag_name' => 'Java', 'user_id' => 1],
            ['tag_name' => 'SQL', 'user_id' => 1],
        ];



        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
