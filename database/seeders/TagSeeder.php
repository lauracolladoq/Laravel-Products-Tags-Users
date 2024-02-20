<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'infantil' => '#B2EBF2',
            'multimedia' => '#E1BEE7',
            'digital' => '#FFF59D',
            'mecanico' => '#E0E0E0',
            'deporte' => '#FFCC80',
            'hardware' => '#D4E157'
        ];

        foreach ($tags as $nombre => $color) {
            Tag::create(compact('nombre', 'color'));
        }
    }
}
