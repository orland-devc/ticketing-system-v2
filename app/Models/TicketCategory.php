<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $fillable = [
        'user_id',
        'name',
    ];

    public function subjects()
    {
        return $this->hasMany(TicketSubject::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
