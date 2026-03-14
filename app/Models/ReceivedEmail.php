<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'temp_email_id',
        'sender_email',
        'sender_name',
        'subject',
        'body_text',
        'body_html',
        'received_at',
        'is_read',
        'message_id',
        'raw_email'
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'is_read' => 'boolean'
    ];

    /**
     * Relationship with email
     */
    public function tempEmail()
    {
        return $this->belongsTo(TempEmail::class, 'temp_email_id');
    }

    /**
     * Mark email as read
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Scope for unread emails
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for read emails
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Get formatted received date
     */
    public function getFormattedReceivedAtAttribute()
    {
        return $this->received_at ? $this->received_at->format('d M Y H:i:s') : '';
    }

    /**
     * Get short subject (truncated)
     */
    public function getShortSubjectAttribute()
    {
        return strlen($this->subject) > 50 
            ? substr($this->subject, 0, 50) . '...' 
            : $this->subject;
    }

    /**
     * Get preview text from body
     */
    public function getPreviewTextAttribute()
    {
        $text = strip_tags($this->body_html ?: $this->body_text);
        return strlen($text) > 100 
            ? substr($text, 0, 100) . '...' 
            : $text;
    }
}