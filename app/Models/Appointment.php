<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'client_name',
        'client_email',
        'client_phone',
        'date',
        'start_time',
        'end_time',
        'status',
        'notes',
        'cancellation_reason',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Un RDV appartient à un utilisateur (le pro)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un RDV appartient à un service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Scope pour filtrer par statut
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }
}
