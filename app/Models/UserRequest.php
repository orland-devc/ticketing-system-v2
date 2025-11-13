<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserRequest extends Model
{
    /** @use HasFactory<\Database\Factories\UserRequestFactory> */
    use HasFactory;

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

    public function getNameAttribute(): string
    {
        $middle = $this->middle_name ? ' '.strtoupper(substr($this->middle_name, 0, 1)).'.' : '';
        $suffix = $this->name_suffix ? ' '.$this->name_suffix : '';

        return "{$this->first_name}{$middle} {$this->last_name}{$suffix}";
    }
}
