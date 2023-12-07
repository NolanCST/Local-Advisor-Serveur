<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    private $categories = ['Hôtel', 'Restaurant', 'Activité en plein air', 'Magasin', 'Spas et bien-être', 'Musée', 'Parc', 'Théâtre', 'Zoo', 'Aquarium', 'Parc aquatique', 'Site historique', 'Cours/Atelier', 'Casino', 'Randonnée', 'Église', 'Cathédrale', 'Balade à vélo', 'Ferme', 'Sports nautique', 'Observatoire', 'Monument', 'Point de vue', 'Station de ski/snowboard', 'Centre de congrès/conférences', 'Station thermale', 'Jardin', 'Aire de jeux', 'Salle de jeux'];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->categories as $category) {
            Category::factory()->create(['name' => $category]);
        }
    }
}
