<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'statut',
        'total',
        'adresse_livraison',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    public const STATUTS = [
        'en_attente' => 'En attente',
        'validee' => 'Validée',
        'expediee' => 'Expédiée',
        'annulee' => 'Annulée',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function produits(): BelongsToMany
    {
        return $this->belongsToMany(Produit::class, 'commande_produit')
            ->withPivot(['quantite', 'prix_unitaire'])
            ->withTimestamps();
    }
}
