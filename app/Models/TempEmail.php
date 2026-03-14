<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TempEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_address',
        'domain',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    /**
     * Relationship with received emails
     */
    public function receivedEmails()
    {
        return $this->hasMany(ReceivedEmail::class, 'temp_email_id');
    }

    /**
     * Check if the email is still active and not expired
     */
    public function isActive()
    {
        return $this->is_active && 
               ($this->expires_at === null || $this->expires_at->isFuture());
    }

    /**
     * Generate a new random email address
     */
    public static function generateRandomEmail($domain = 'revacantik.my.id')
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $length = rand(5, 12);
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $randomString . '@' . $domain;
    }

    /**
     * Scope for active emails only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Scope for expired emails
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }
}