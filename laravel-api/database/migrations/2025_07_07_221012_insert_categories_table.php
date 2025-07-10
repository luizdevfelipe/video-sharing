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
        $categories = [
            [
                'id' => 1,
                'name' => 'action',
                'title' => 'Action',
                'description' => 'Movies and videos full of adrenaline and thrilling scenes.',
                'lang' => 'en',
            ],
            [
                'id' => 2,
                'name' => 'comedy',
                'title' => 'Comedy',
                'description' => 'Funny content to entertain and amuse.',
                'lang' => 'en',
            ],
            [
                'id' => 3,
                'name' => 'drama',
                'title' => 'Drama',
                'description' => 'Engaging and emotional stories that explore human relationships.',
                'lang' => 'en',
            ],
            [
                'id' => 4,
                'name' => 'documentary',
                'title' => 'Documentary',
                'description' => 'Informative and educational videos based on real facts.',
                'lang' => 'en',
            ],
            [
                'id' => 5,
                'name' => 'horror',
                'title' => 'Horror',
                'description' => 'Scary movies and videos for suspense and fear fans.',
                'lang' => 'en',
            ],
            [
                'id' => 6,
                'name' => 'sci-fi',
                'title' => 'Sci-Fi',
                'description' => 'Futuristic stories, advanced technology, and imaginary worlds.',
                'lang' => 'en',
            ],
            [
                'id' => 7,
                'name' => 'animation',
                'title' => 'Animation',
                'description' => 'Animated content for all ages, from children to adults.',
                'lang' => 'en',
            ],
            [
                'id' => 8,
                'name' => 'music',
                'title' => 'Music',
                'description' => 'Music videos, live performances, and music documentaries.',
                'lang' => 'en',
            ],
            [
                'id' => 9,
                'name' => 'sports',
                'title' => 'Sports',
                'description' => 'Matches, documentaries, and content about various sports.',
                'lang' => 'en',
            ],
            [
                'id' => 10,
                'name' => 'education',
                'title' => 'Education',
                'description' => 'Didactic videos and tutorials for learning and personal development.',
                'lang' => 'en',
            ],
            // pt-br versions
            [
                'id' => 11,
                'name' => 'action',
                'title' => 'Ação',
                'description' => 'Filmes e vídeos cheios de adrenalina e cenas emocionantes.',
                'lang' => 'pt-br',
            ],
            [
                'id' => 12,
                'name' => 'comedy',
                'title' => 'Comédia',
                'description' => 'Conteúdo engraçado para entreter e divertir.',
                'lang' => 'pt-br',
            ],
            [
                'id' => 13,
                'name' => 'drama',
                'title' => 'Drama',
                'description' => 'Histórias envolventes e emocionantes que exploram relações humanas.',
                'lang' => 'pt-br',
            ],
            [
                'id' => 14,
                'name' => 'documentary',
                'title' => 'Documentário',
                'description' => 'Vídeos informativos e educativos baseados em fatos reais.',
                'lang' => 'pt-br',
            ],
            [
                'id' => 15,
                'name' => 'horror',
                'title' => 'Terror',
                'description' => 'Filmes e vídeos assustadores para fãs de suspense e medo.',
                'lang' => 'pt-br',
            ],
            [
                'id' => 16,
                'name' => 'sci-fi',
                'title' => 'Ficção Científica',
                'description' => 'Histórias futuristas, tecnologia avançada e mundos imaginários.',
                'lang' => 'pt-br',
            ],
            [
                'id' => 17,
                'name' => 'animation',
                'title' => 'Animação',
                'description' => 'Conteúdo animado para todas as idades, de crianças a adultos.',
                'lang' => 'pt-br',
            ],
            [
                'id' => 18,
                'name' => 'music',
                'title' => 'Música',
                'description' => 'Videoclipes, apresentações ao vivo e documentários musicais.',
                'lang' => 'pt-br',
            ],
            [
                'id' => 19,
                'name' => 'sports',
                'title' => 'Esportes',
                'description' => 'Partidas, documentários e conteúdo sobre diversos esportes.',
                'lang' => 'pt-br',
            ],
            [
                'id' => 20,
                'name' => 'education',
                'title' => 'Educação',
                'description' => 'Vídeos didáticos e tutoriais para aprendizado e desenvolvimento pessoal.',
                'lang' => 'pt-br',
            ],
        ];

        foreach ($categories as &$category) {
            $category['created_at'] = now();
            $category['updated_at'] = now();
        }

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')->delete();
    }
};
