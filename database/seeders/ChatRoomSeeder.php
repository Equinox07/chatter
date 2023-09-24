<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chat_rooms')->insert([
            'name' => "Accra Tours",
            'slug' => Str::slug("Accra Tours")
        ]);
        DB::table('chat_rooms')->insert([
            'name' => "Tech Tours",
            'slug' => Str::slug("Tech Tours")
        ]);
    }
}
