<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ticket_code',
        'sender_id',
        'assigned_to',
        'level',
        'subject',
        'category',
        'content',
        'status',
        'guest_name',
        'guest_birthdate',
        'guest_email',
        'guest_tracking_token',
    ];

    protected static function booted()
    {
        static::creating(function ($request) {
            $date = now()->format('ymd');
            $attempt = 0;

            do {
                $random = strtoupper(Str::random(3));
                $suffix = $attempt > 0 ? '-'.str_pad($attempt, 2, '0', STR_PAD_LEFT) : '';
                $code = "TCK-{$date}-{$random}{$suffix}";
                $attempt++;
            } while (self::where('ticket_code', $code)->exists());

            $request->ticket_code = $code;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function assigendTicket()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
