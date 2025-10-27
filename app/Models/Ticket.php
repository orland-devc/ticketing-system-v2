<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
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

    public function generateTicketId(): string
    {
        $encodedTime = base_convert(now()->format('dH'), 10, 36);
        $randomCode = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4));
        $ticketId = "TKT{$encodedTime}{$randomCode}";

        return $this->ticketExists($ticketId) ? $this->generateTicketId() : $ticketId;
    }

    private function ticketExists(string $ticketId): bool
    {
        return Ticket::where('ticket_code', $ticketId)->exists();
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
