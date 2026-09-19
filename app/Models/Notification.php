<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_target',
        'title',
        'message',
        'type',
        'category',
        'icon',
        'reference_id',
        'reference_type',
        'is_read',
        'source',
        'action_url',
        'meta',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'meta'       => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForPlatform($query, $platform)
    {
        // Web: tampilkan SEMUA notif (biar user bisa lihat history lengkap)
        if ($platform === 'web') {
            return $query;
        }
        
        // Mobile: tampilkan notif dari web & system aja
        // (biar nggak dobel sama notif yang dia sendiri bikin)
        if ($platform === 'mobile') {
            return $query->whereIn('source', ['web', 'system']);
        }
        
        return $query;
    }

    public function scopeForRole($query, $role)
    {
        return $query->where(function ($q) use ($role) {
            $q->where('role_target', 'all')
              ->orWhere('role_target', $role);
        });
    }
}