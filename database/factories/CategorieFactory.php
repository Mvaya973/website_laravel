<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategorieFactory extends Factory
{
    protected $model = Categorie::class;

    public function definition(): array
    {
        $nom = fake()->unique()->randomElement([
            'Ordinateurs portables',
            'Smartphones',
            'Tablettes',
            'Accessoires',
            'Audio',
            'Composants',
            'Objets connectés',
            'Photo & vidéo',
            'Gaming',
            'Réseau',
        ]);

        return [
            'nom' => $nom,
            'slug' => Str::slug($nom),
        ];
    }
}
