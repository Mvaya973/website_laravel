<?php

namespace Database\Factories;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
{
    protected $model = Produit::class;

    private const TYPES = [
        'Ordinateur portable',
        'Smartphone',
        'Tablette',
        'Casque audio',
        'Clavier mécanique',
        'Souris sans fil',
        'Enceinte Bluetooth',
        'Disque SSD externe',
        'Webcam',
        'Chargeur rapide',
        'Montre connectée',
        'Câble USB-C',
        'Routeur Wi-Fi',
        'Carte graphique',
        'Microphone USB',
        'Écran PC',
        'Imprimante',
        'Batterie externe',
        'Support pour ordinateur',
        'Barre de son',
    ];

    private const MARQUES = [
        'TechPro', 'Nova', 'Zenith', 'Quantum', 'Pulse',
        'Vortex', 'Apex', 'Nexa', 'Orion', 'Vertex',
        'Skyline', 'Atlas', 'Fusion', 'Nimbus', 'Kinetic',
    ];

    public function definition(): array
    {
        $type = fake()->randomElement(self::TYPES);
        $marque = fake()->randomElement(self::MARQUES);
        $modele = strtoupper(fake()->bothify('??##'));

        return [
            'nom' => "{$type} {$marque} {$modele}",
            'description' => fake()->paragraph(),
            'prix' => fake()->randomFloat(2, 9, 1500),
            'stock' => fake()->numberBetween(0, 50),
            'image' => null,
        ];
    }
}
