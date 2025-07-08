<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('categories')->insert([
            ['id' => '1', 'name' => 'action', 'description' => 'Movies and videos full of adrenaline and thrilling scenes.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '2', 'name' => 'comedy', 'description' => 'Funny content to entertain and amuse.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '3', 'name' => 'drama', 'description' => 'Engaging and emotional stories that explore human relationships.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '4', 'name' => 'documentary', 'description' => 'Informative and educational videos based on real facts.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '5', 'name' => 'horror', 'description' => 'Scary movies and videos for suspense and fear fans.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '6', 'name' => 'sci-fi', 'description' => 'Futuristic stories, advanced technology, and imaginary worlds.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '7', 'name' => 'animation', 'description' => 'Animated content for all ages, from children to adults.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '8', 'name' => 'music', 'description' => 'Music videos, live performances, and music documentaries.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '9', 'name' => 'sports', 'description' => 'Matches, documentaries, and content about various sports.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => '10', 'name' => 'education', 'description' => 'Didactic videos and tutorials for learning and personal development.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')->delete();
    }
};
