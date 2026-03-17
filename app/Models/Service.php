<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'duration',
        'price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Un service appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
