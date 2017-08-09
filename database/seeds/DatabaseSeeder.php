<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\VideoType::insert([
            [
                'name' => '乱伦',
            ],
            [
                'name' => '人妻',
            ],
            [
                'name' => '偷拍',
            ],
            [
                'name' => '学生',
            ],
            [
                'name' => '巨乳',
            ],
            [
                'name' => '日韩',
            ],
            [
                'name' => '欧美',
            ],
            [
                'name' => '国产',
            ],
            [
                'name' => '动漫',
            ],
        ]);
    }
}
