<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'description',
        'attachment_url',
        'attachment_original_name',
        'client_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'answered_at' => 'datetime',
    ];

    protected $dateTimeFormat = 'd.m.Y H:i:s';

    /**
     * Get the user associated with the feedback.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get duration of left time to allow to write a new feedback.
     */
    public function getTimeLeftAttribute() {
        return $this->created_at->addDays(1)->diffForHumans(now(), null, false, 2);
        // return now()->diffForHumans($this->created_at->addDays(1), null, true, 2);
    }
}
