<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redirection extends Model
{
    // Si tu utilises timestamps créés avec $table->timestamps()
    protected $fillable = ['old_url', 'new_url', 'status'];

    // Si tu utilises des colonnes personnalisées pour les dates, tu peux configurer ici (optionnel)
    // protected $dates = ['date_created', 'date_modified'];
}
