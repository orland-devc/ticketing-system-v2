<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'name',
    ];

    public function staffs()
    {
        return $this->hasMany(User::class, 'office_id');
    }

    public function head()
    {
        return $this->hasOne(User::class, 'office_id')->where('role', 'head')->first();
    }
}
