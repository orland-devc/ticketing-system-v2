<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserRequest extends Model
{
    protected $fillable = [
        'request_code',
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'name_suffix',
        'course',
        'level',
        'role',
        'role',
        'email',
        'is_approved',
        'is_rejected',
        'reason',
    ];

    protected static function booted()
    {
        static::creating(function ($request) {
            $date = now()->format('ymd');
            $attempt = 0;

            do {
                $random = strtoupper(Str::random(3));
                $suffix = $attempt > 0 ? '-'.str_pad($attempt, 2, '0', STR_PAD_LEFT) : '';
                $code = "REQ-{$date}-{$random}{$suffix}";
                $attempt++;
            } while (self::where('request_code', $code)->exists());

            $request->request_code = $code;
        });
    }
}
