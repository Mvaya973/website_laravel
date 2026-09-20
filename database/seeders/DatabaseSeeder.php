<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        $client = User::factory()->create([
            'name' => 'Client Test',
            'email' => 'test@example.com',
            'is_admin' => false,
        ]);

        $categories = Categorie::factory()->count(6)->create();

        $produits = Produit::factory()
            ->count(24)
            ->create()
            ->each(function (Produit $produit) use ($categories) {
                $produit->categories()->attach(
                    $categories->random(random_int(1, 2))->pluck('id')
                );
            });

        $lignes = $produits->random(3);
        $total = 0;

        $commande = Commande::create([
            'user_id' => $client->id,
            'statut' => 'validee',
            'total' => 0,
            'adresse_livraison' => '12 rue des Développeurs, 75000 Paris',
        ]);

        foreach ($lignes as $produit) {
            $quantite = random_int(1, 3);

            $commande->produits()->attach($produit->id, [
                'quantite' => $quantite,
                'prix_unitaire' => $produit->prix,
            ]);

            $total += $produit->prix * $quantite;
        }

        $commande->update(['total' => $total]);
    }
}
